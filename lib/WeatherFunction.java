import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.nio.charset.Charset;
import java.nio.charset.StandardCharsets;

import org.json.JSONArray;
import org.json.JSONObject;

import com.serverless.ServerlessFunction;

public class WeatherFunction implements ServerlessFunction {

    private static final int CONNECT_TIMEOUT = 30 * 1000; // milliseconds
    private static final int READ_TIMEOUT = 30 * 1000; // milliseconds

    private static final String OPEN_WEATHER_URL = "http://api.openweathermap.org/data/2.5/forecast"
            + "?appid=8cdd8be4b179a529afa5f2ffae4b9858&units=metric";
    private static final int NUM_FORECASTS = 8;

    @Override
    public JSONObject execute(JSONObject input) {
        JSONObject output = new JSONObject();

        HttpURLConnection httpConn = null;
        InputStream inputStream = null;
        try {
            String city = input.getString("city");
            String country = input.getString("country");
            String location = urlEncode(city + "," + country, StandardCharsets.UTF_8);
            URL url = new URL(OPEN_WEATHER_URL + "&q=" + location);

            httpConn = (HttpURLConnection) url.openConnection();
            httpConn.setConnectTimeout(CONNECT_TIMEOUT);
            httpConn.setReadTimeout(READ_TIMEOUT);

            inputStream = httpConn.getInputStream();
            String respBody = inputStreamToString(inputStream, StandardCharsets.UTF_8);

            JSONObject openWeather = new JSONObject(respBody);
            JSONArray openWeatherForecasts = openWeather.getJSONArray("list");
            JSONArray forecasts = new JSONArray();

            for (int i = 0; i < NUM_FORECASTS; i++) {
                JSONObject openWeatherForecast = openWeatherForecasts.getJSONObject(i);
                JSONObject forecast = new JSONObject();

                String timestamp = openWeatherForecast.getString("dt_txt");
                String fcast = openWeatherForecast.getJSONArray("weather").getJSONObject(0).getString("description");
                double temperature = openWeatherForecast.getJSONObject("main").getDouble("temp");

                forecast.put("timestamp", timestamp);
                forecast.put("forecast", fcast);
                forecast.put("temperature", Math.round(temperature));

                forecasts.put(forecast);
            }

            output.put("city", city);
            output.put("country", country);
            output.put("forecasts", forecasts);
        } catch (IOException e) {
            output.put("error", e.toString());
        } finally {
            if (inputStream != null) {
                try {
                    inputStream.close();
                } catch (IOException e) {
                }
            }
            if (httpConn != null) {
                httpConn.disconnect();
            }
        }

        return output;
    }

    private static String urlEncode(String str, Charset encoding) throws UnsupportedEncodingException {
        return URLEncoder.encode(str, encoding.name());
    }

    private static String inputStreamToString(InputStream input, Charset encoding) throws IOException {
        ByteArrayOutputStream output = new ByteArrayOutputStream();
        byte[] buffer = new byte[1024];
        int length;
        while ((length = input.read(buffer)) != -1) {
            output.write(buffer, 0, length);
        }
        return output.toString(encoding.name());
    }

}
