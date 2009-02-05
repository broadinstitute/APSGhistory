/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action.role;

import com.atlassian.crowd.integration.soap.SOAPRole;
import com.atlassian.crowd.security.demo.action.BaseAction;
import com.atlassian.crowd.security.demo.action.group.ViewGroup;
import org.apache.log4j.Logger;

public class ViewRole extends BaseAction {
    private static final Logger logger = Logger.getLogger(ViewGroup.class);

    private SOAPRole role;

    private String name;
    private String description;
    private boolean active;

    public String doDefault () {
        try {
            role = securityServerClient.findRoleByName(name);

            this.description = role.getDescription();
            this.active = role.isActive();

        } catch (Exception e) {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return SUCCESS;
    }

    public SOAPRole getRole() {
        return role;
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

    public boolean isActive() {
        return active;
    }

    public void setActive(boolean active) {
        this.active = active;
    }
}