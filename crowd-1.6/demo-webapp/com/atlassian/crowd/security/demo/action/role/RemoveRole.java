/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action.role;

import com.atlassian.crowd.security.demo.action.BaseAction;
import org.apache.log4j.Logger;

public class RemoveRole extends BaseAction {
    private static final Logger logger = Logger.getLogger(RemoveRole.class);

    private String name;

    public String doDefault () {
        try {
            // make sure the group exist, display errors if there is a problem
            securityServerClient.findRoleByName(name);

        } catch (Exception e) {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    public String doUpdate() {
        try {

            securityServerClient.removeRole(name);

            return SUCCESS;

        } catch (Exception e) {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

}
