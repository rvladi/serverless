package com.serverless;

import org.json.JSONObject;

public interface ServerlessFunction {

	JSONObject execute(JSONObject input);

}
