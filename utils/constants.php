<?php
const DB_HOST = 'db_host';
const DB_USER = 'db_user';
const DB_PASSWORD = 'db_password';
const DB_NAME = 'db_name';
const DB_CHARSET = 'utf8';
const DB_DUP_ENTRY = 1062;

const REQUEST_URI = 'REQUEST_URI';
const REQUEST_METHOD = 'REQUEST_METHOD';
const GET = 'GET';
const POST = 'POST';

const INVALID_REQUEST_METHOD = 'Invalid request method';
const INVALID_CREDENTIALS = 'Invalid credentials';

const MIN_UNAME_LEN = 6;
const MIN_PASSW_LEN = 6;

const USERNAME = 'username';
const PASSWORD = 'password';
const LOCATION = 'location';
const STATUS = 'status';
const SUCCESS = 'success';
const FAILURE = 'failure';
const ERROR = 'error';

const USER_ID = 'user_id';
const FORMAT = 'format';
const JSON = 'JSON';

const START_DATE = 'start_date';
const END_DATE = 'end_date';

const ID = 'id';
const NAME = 'name';
const DESCRIPTION = 'description';
const BODY = 'body';
const CREATED = 'created';
const UPDATED = 'updated';
const EXECUTED = 'executed';
const EXECUTIONS = 'executions';

const PARAM = 'param';

const JAVA_CLASSPATH = '"../lib/*"';
const JAVA_SECURITY_MANAGER = 'com.serverless.ServerlessSecurityManager';
const JAVA_SECURITY_POLICY = '../lib/serverless.policy';
const JAVA_FUNC_EXECUTOR = 'com.serverless.ServerlessExecutor';
const JAVA_FUNC_ROOT = '../funcs';
const JAVA_CLASS_PREFIX = 'C';

define('BODY_TEMPLATE', file_get_contents('../lib/MyFunction.java'));
define('PARAM_TEMPLATE', file_get_contents('../lib/MyParameter.json'));
