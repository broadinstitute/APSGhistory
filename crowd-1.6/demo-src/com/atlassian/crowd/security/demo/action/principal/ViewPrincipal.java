/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action.principal;

import com.atlassian.crowd.integration.exception.InvalidAuthorizationTokenException;
import com.atlassian.crowd.integration.exception.ObjectNotFoundException;
import com.atlassian.crowd.integration.soap.*;
import com.atlassian.crowd.integration.model.RemotePrincipalConstants;
import com.atlassian.crowd.security.demo.action.BaseAction;

import java.rmi.RemoteException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

public class ViewPrincipal extends BaseAction
{
    protected SOAPPrincipal principal;
    protected SOAPGroup[] soapGroups;
    protected SOAPRole[] soapRoles;

    protected List subscribedGroups;
    protected List unsubscribedGroups;

    protected List subscribedRoles;
    protected List unsubscribedRoles;

    protected String name;
    protected String description;
    protected boolean active;
    protected String firstname;
    protected String lastname;
    protected String email;
    protected String password;
    protected String passwordConfirm;

    public String doDefault()
    {
        try
        {
            processGeneral();
            processMemberships();

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return SUCCESS;
    }

    protected void processGeneral() throws InvalidAuthorizationTokenException, RemoteException, ObjectNotFoundException
    {
        principal = securityServerClient.findPrincipalByName(name);

        this.description = principal.getDescription();
        this.active = principal.isActive();

        for (int i = 0; i < principal.getAttributes().length; i++)
        {
            SOAPAttribute attribute = principal.getAttributes()[i];

            if (attribute.getName().equals(RemotePrincipalConstants.FIRSTNAME))
            {
                firstname = attribute.getValues()[0];
            }
            else if (attribute.getName().equals(RemotePrincipalConstants.LASTNAME))
            {
                lastname = attribute.getValues()[0];
            }
            else if (attribute.getName().equals(RemotePrincipalConstants.EMAIL))
            {
                email = attribute.getValues()[0];
            }
        }
    }

    protected void processMemberships() throws InvalidAuthorizationTokenException, RemoteException
    {
        // find all the groups/roles
        SearchRestriction[] searchRestrictions = new SearchRestriction[0];
        soapGroups = securityServerClient.searchGroups(searchRestrictions);
        soapRoles = securityServerClient.searchRoles(searchRestrictions);

        // setup our list for the view page
        processGroups();
        processRoles();
    }

    protected List processGroups()
    {
        unsubscribedGroups = new ArrayList();
        subscribedGroups = new ArrayList();

        try
        {
            for (int i = 0; i < soapGroups.length; i++)
            {
                SOAPGroup group = soapGroups[i];

                List members = new ArrayList(Arrays.asList(group.getMembers()));

                // this seems to be faster verses ldap because of having to do a connection per lookup
                if (members.contains(principal.getName()))
                {
                    subscribedGroups.add(group);

                }
                else
                {
                    unsubscribedGroups.add(group);
                }
            }

        }
        catch (Exception e)
        {
            logger.warn(e.getMessage(), e);
        }

        return unsubscribedGroups;
    }

    protected List processRoles()
    {
        unsubscribedRoles = new ArrayList();
        subscribedRoles = new ArrayList();

        try
        {
            for (int i = 0; i < soapRoles.length; i++)
            {
                SOAPRole role = soapRoles[i];

                List members = new ArrayList(Arrays.asList(role.getMembers()));

                // this seems to be faster verses ldap because of having to do a connection per lookup
                if (members.contains(principal.getName()))
                {
                    subscribedRoles.add(role);

                }
                else
                {
                    unsubscribedRoles.add(role);
                }
            }

        }
        catch (Exception e)
        {
            logger.warn(e.getMessage(), e);
        }

        return unsubscribedGroups;
    }

    public SOAPPrincipal getPrincipal()
    {
        return principal;
    }

    public List getSubscribedGroups()
    {
        return subscribedGroups;
    }

    public List getUnsubscribedGroups()
    {
        return unsubscribedGroups;
    }

    public List getSubscribedRoles()
    {
        return subscribedRoles;
    }

    public List getUnsubscribedRoles()
    {
        return unsubscribedRoles;
    }

    public boolean isActive()
    {
        return active;
    }

    public void setActive(boolean active)
    {
        this.active = active;
    }

    public String getDescription()
    {
        return description;
    }

    public void setDescription(String description)
    {
        this.description = description;
    }

    public String getName()
    {
        return name;
    }

    public void setName(String name)
    {
        this.name = name;
    }

    public String getFirstname()
    {
        return firstname;
    }

    public void setFirstname(String firstname)
    {
        this.firstname = firstname;
    }

    public String getLastname()
    {
        return lastname;
    }

    public void setLastname(String lastname)
    {
        this.lastname = lastname;
    }

    public String getEmail()
    {
        return email;
    }

    public void setEmail(String email)
    {
        this.email = email;
    }

    public String getPassword()
    {
        return password;
    }

    public void setPassword(String password)
    {
        this.password = password;
    }

    public String getPasswordConfirm()
    {
        return passwordConfirm;
    }

    public void setPasswordConfirm(String passwordConfirm)
    {
        this.passwordConfirm = passwordConfirm;
    }

}