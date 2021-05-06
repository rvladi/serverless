import org.json.JSONObject;

import com.serverless.ServerlessFunction;

public class MyFunction implements ServerlessFunction {

    @Override
    public JSONObject execute(JSONObject input) {
        JSONObject output = new JSONObject();
        output.put("message", "Hello World!");
        output.put("success", true);
        return output;
    }

}
