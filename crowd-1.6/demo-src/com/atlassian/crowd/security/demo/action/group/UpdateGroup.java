package com.atlassian.crowd.security.demo.action.group;

import com.atlassian.crowd.integration.exception.ApplicationPermissionException;
import com.atlassian.crowd.integration.exception.InvalidAuthorizationTokenException;
import com.atlassian.crowd.integration.exception.ObjectNotFoundException;
import com.atlassian.crowd.integration.soap.SOAPGroup;
import com.atlassian.crowd.security.demo.action.BaseAction;
import org.apache.commons.lang.StringUtils;

import java.rmi.RemoteException;

/**
 * Action to update a Groups groupDescription and 'active' state
 */
public class UpdateGroup extends BaseAction
{
    private String name;

    private boolean active;

    private String groupDescription;

    public String doUpdate()
    {

        doValidation();
        if (hasErrors())
        {
            return ERROR;
        }

        try
        {
            SOAPGroup group = securityServerClient.findGroupByName(name);

            if (StringUtils.isNotBlank(groupDescription))
            {
                group.setDescription(groupDescription);
            }

            group.setActive(active);

            // Update the group
            securityServerClient.updateGroup(group.getName(), group.getDescription(), group.isActive());

        }
        catch (RemoteException e)
        {
            addActionError("RemoteException: " + e.getMessage());
        }
        catch (InvalidAuthorizationTokenException e)
        {
            addActionError("Invalid authorisation");
        }
        catch (ObjectNotFoundException e)
        {
            addActionError("The group you are trying to update does not exist");
        }
        catch (ApplicationPermissionException e)
        {
            addActionError("Failed to update group, no permissions");
        }

        return SUCCESS;
    }

    private void doValidation()
    {
        if (StringUtils.isBlank(name))
        {
            addFieldError("name", "You must supply a name field");
        }
    }

    public String getName()
    {
        return name;
    }

    public void setName(String name)
    {
        this.name = name;
    }

    public String getGroupDescription()
    {
        return groupDescription;
    }

    public void setGroupDescription(String groupDescription)
    {
        this.groupDescription = groupDescription;
    }

    public boolean isActive()
    {
        return active;
    }

    public void setActive(boolean active)
    {
        this.active = active;
    }
}
