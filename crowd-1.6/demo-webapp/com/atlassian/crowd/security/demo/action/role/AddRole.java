/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action.role;

import com.atlassian.crowd.integration.soap.SOAPRole;
import com.atlassian.crowd.security.demo.action.BaseAction;
import org.apache.log4j.Logger;

public class AddRole extends BaseAction {
    private static final Logger logger = Logger.getLogger(AddRole.class);

    private SOAPRole role;

    private boolean active;
    private String description;
    private String name;


    public String doDefault() {
        return INPUT;
    }

    public String doUpdate() {
        try {
           // check for errors
            doValidation();
            if (hasErrors() || hasActionErrors()) {
                return INPUT;
            }

            // build our role object
            role = new SOAPRole();
            role.setActive(active);
            role.setDescription(description);
            role.setName(name);

            // have the security server add it
            role = securityServerClient.addRole(role);

            return SUCCESS;

        } catch (Exception e) {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    protected void doValidation() {

        if (name == null || name.equals("")) {
            addFieldError("name", getText("role.name.invalid"));

        } else {
            try {
                securityServerClient.findRoleByName(name);

                // this isn't good, this name already exist
                addFieldError("name", getText("invalid.namealreadyexist"));

            } catch (Exception e) {
                // ignore
            }
        }
    }

    public SOAPRole getRole() {
        return role;
    }

    public boolean isActive() {
        return active;
    }

    public void setActive(boolean active) {
        this.active = active;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

}