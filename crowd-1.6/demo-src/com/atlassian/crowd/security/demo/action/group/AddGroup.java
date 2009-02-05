/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action.group;

import com.atlassian.crowd.integration.soap.SOAPGroup;
import com.atlassian.crowd.security.demo.action.BaseAction;

public class AddGroup extends BaseAction
{
    private SOAPGroup group;
    private boolean active;
    private String groupDescription;
    private String name;

    public String doUpdate()
    {
        try
        {
            // check for errors
            doValidation();
            if (hasErrors() || hasActionErrors())
            {
                return INPUT;
            }

            // build our group object
            group = new SOAPGroup();
            group.setActive(active);
            group.setDescription(groupDescription);
            group.setName(name);

            // have the security server add it
            group = securityServerClient.addGroup(group);

            return SUCCESS;

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    public String doDefault()
    {
        return INPUT;
    }

    protected void doValidation()
    {

        if (name == null || name.equals(""))
        {
            addFieldError("name", getText("group.name.invalid"));

        }
        else
        {
            try
            {
                securityServerClient.findGroupByName(name);

                // this isn't good, this name already exist
                addFieldError("name", getText("invalid.namealreadyexist"));

            }
            catch (Exception e)
            {
                // ignore
            }
        }
    }

    public SOAPGroup getGroup()
    {
        return group;
    }

    public boolean isActive()
    {
        return active;
    }

    public void setActive(boolean active)
    {
        this.active = active;
    }

    public String getGroupDescription()
    {
        return groupDescription;
    }

    public void setGroupDescription(String groupDescription)
    {
        this.groupDescription = groupDescription;
    }

    public String getName()
    {
        return name;
    }

    public void setName(String name)
    {
        this.name = name;
    }
}