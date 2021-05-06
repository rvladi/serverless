package com.serverless;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.PrintStream;
import java.nio.charset.Charset;
import java.nio.charset.StandardCharsets;

import org.json.JSONObject;

public class ServerlessExecutor {

	public static void main(String[] args) {
		InputStream in = System.in;
		PrintStream out = System.out;
		PrintStream err = System.err;
		try {
			// reassign standard streams
			System.setIn(new NullInputStream());
			System.setOut(new PrintStream(new NullOutputStream()));
			System.setErr(new PrintStream(new NullOutputStream()));

			// load serverless function
			ServerlessFunction function = loadFunction(args[0]);

			// execute serverless function
			String inputStr = inputStreamToString(in, StandardCharsets.UTF_8);
			JSONObject input = new JSONObject(inputStr);
			JSONObject output = function.execute(input);
			out.println(output.toString(2));
		} catch (Throwable t) {
			err.println(t.toString());
		}
	}

	private static ServerlessFunction loadFunction(String className) throws ReflectiveOperationException {
		ClassLoader loader = ServerlessExecutor.class.getClassLoader();
		Class<?> clazz = loader.loadClass(className);
		return (ServerlessFunction) clazz.newInstance();
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
