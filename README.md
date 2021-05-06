# Serverless Computing Service: Function as a Service

The Serverless Computing Service (SCS) lets users run code without provisioning, managing or administering servers. SCS is a web application hosted on Amazon Web Services (AWS). It uses flexible resource management to provide a high quality of service.

Users can create and execute serverless functions written in Java. Serverless functions can use the Java standard library. Each serverless function has a single parameter in JSON format. It returns a result which is also a JSON object.

SCS offers a web interface and REST API with capabilities for user registration, logging in/out, creating, editing, deleting, browsing, and executing functions. The user can view the result of a function execution in JSON format in the web interface or in the response from a REST API endpoint.

SCS implements a comprehensive security mechanism to ensure tenant and function execution isolation. To adhere to the latest security-related best practices, SCS stores passwords in hashed form. SCS also preprocesses all user input to prevent Cross-Site Scripting (XSS) and SQL injection attacks. The SCS web application is secured with a Transport Layer Security (TLS) certificate and supports secure communication over the Hypertext Transfer Protocol Secure (HTTPS).

## Web Application Design

### Software Stack

SCS is a web application which runs on the LAMP stack. The LAMP stack is a set of open-source software which consists of the Linux operating system, the Apache HTTP Server, the MySQL relational database management system, and the PHP programming language. SCS is deployed on Amazon Elastic Compute Cloud (EC2).

### User Interface (Front End)

The front end implements the user interface. It is developed using HTML5 and CSS3 and follows the responsive web design paradigm. The responsive web design approach responds to environment changes related to screen size, platform and orientation.

In order to use the service, all users must first register. The user interface includes HTML pages for user registration/sign-up and login. SCS offers a web interface through which users can create, edit, delete, browse, and execute serverless functions.

To create a function, the user needs to enter the name, description and source code of the function in the designated text fields. The user can also view and edit the source code of previously created functions. To execute a function, the user selects the function and enters a JSON value for the function parameter. The user can then view the result of the execution in JSON format.

User input validation is performed on two levels. First, all data entered by the user in the user interface is processed before sending an HTTP request to the back end. Second, all parameters of an HTTP request to a REST API endpoint are processed before the request is executed.

Users are able to browse all serverless functions they have created. They can also filter the list of functions by name and creation date range.

### Server Side (Back End)

The back end of the SCS web application is developed with PHP following the Model-View-Controller (MVC) architecture. Implementing the MVC paradigm allows SCS to support different clients by generating HTML and JSON responses from the same model. SCS offers a REST API with capabilities for user registration, logging in and logging out. The REST API includes creating, editing, deleting, browsing, and executing serverless functions. HTTP POST requests are used to create and execute functions. HTTP GET requests are used to view the source code of a function as well as browse and filter the list of functions.

## Web Application Security

### PHP Sessions

All REST API endpoints return data only if the user has logged in successfully in the same session by calling the login REST API. All HTML pages with the exception of the home page can be viewed only by users who have already logged in. If a non-logged in user tries to access a page, they will be redirected to the login page which also contains a registration link. This behavior is implemented using PHP's session capabilities (`PHPSESSID` cookie).

### Function Access Control

A user has access to and can view, edit, delete, and execute only functions created by them. To ensure this, the id of the currently logged-in user is included in every SQL database query. The user id is associated with the PHP session. As a result, a malicious user cannot get access to other users' functions through manipulation of the HTTP request parameters.

### Password Security

Every user must register and enter a password. Only passwords which comply with SCS's requirements related to password length and complexity are accepted. All passwords are stored in hashed form in the MySQL database.

### Preventing Cross-Site Scripting (XSS) and SQL Injection Attacks

To prevent Cross-Site Scripting (XSS), SCS preprocesses all user input (function name, description, body, etc.) by escaping special HTML characters (&, ", ', <, >). To prevent SQL injection attacks, all strings entered by the user are processed by the `mysqli_real_escape_string` PHP function before being inserted into SQL queries.

### Transport Layer Security (TLS) and HTTPS

The SCS web application is secured with a Transport Layer Security (TLS) certificate and supports secure communication over the Hypertext Transfer Protocol Secure (HTTPS). The TLS certificate is obtained from Let's Encrypt—a non-profit certificate authority providing TLS certificates to 200 million websites. Moreover, using settings in an Apache Web Server's configuration file (`.htaccess`), all HTTP requests are automatically redirected to HTTPS.

## Serverless Function Format

To create a function, the user must create a Java class which implements the `ServerlessFunction` interface. This interface contains a single method called `execute`. The `execute` method takes a JSON object as a parameter and returns a JSON object.

```java
import org.json.JSONObject;
import com.serverless.ServerlessFunction;

public class MyFunction implements ServerlessFunction
{
  @Override
  public JSONObject execute(JSONObject input)
  {
    JSONObject output = new JSONObject();
    output.put("message", "Hello World!");
    output.put("success", true);
    return output;
  }
}
```

The user-defined `execute` method can use the Java standard library as well as libraries that have been previously deployed on the server by the SCS administrator.
