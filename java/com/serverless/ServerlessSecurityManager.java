package com.serverless;

import sun.security.util.SecurityConstants;

public class ServerlessSecurityManager extends SecurityManager {

	@Override
	public void checkAccess(Thread t) {
		checkPermission(SecurityConstants.MODIFY_THREAD_PERMISSION);
	}

	@Override
	public void checkAccess(ThreadGroup g) {
		checkPermission(SecurityConstants.MODIFY_THREADGROUP_PERMISSION);
	}

	@Override
	public void checkExit(int status) {
		throw new SecurityException();
	}

}
