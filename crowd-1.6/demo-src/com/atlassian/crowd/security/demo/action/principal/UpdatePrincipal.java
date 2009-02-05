/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action.principal;

import com.atlassian.crowd.integration.authentication.PasswordCredential;
import com.atlassian.crowd.integration.exception.ApplicationPermissionException;
import com.atlassian.crowd.integration.soap.SOAPAttribute;
import com.atlassian.crowd.integration.soap.SOAPPrincipal;
import com.atlassian.crowd.integration.model.RemotePrincipalConstants;
import com.opensymphony.webwork.ServletActionContext;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.Enumeration;
import java.util.List;

public class UpdatePrincipal extends ViewPrincipal
{

    private String removeGroup;
    private String unsubscribedGroup;

    private String removeRole;
    private String unsubscribedRole;

    private String attributes[];
    private String attribute;
    private String value;

    public String doUpdateGeneral()
    {
        try
        {
            SOAPAttribute soapAttribute = new SOAPAttribute();
            soapAttribute.setValues(new String[1]);

            // update personal information

            soapAttribute.setName(RemotePrincipalConstants.EMAIL);
            soapAttribute.getValues()[0] = email;
            securityServerClient.updatePrincipalAttribute(name, soapAttribute);

            soapAttribute.setName(RemotePrincipalConstants.FIRSTNAME);
            soapAttribute.getValues()[0] = firstname;
            securityServerClient.updatePrincipalAttribute(name, soapAttribute);

            soapAttribute.setName(RemotePrincipalConstants.LASTNAME);
            soapAttribute.getValues()[0] = lastname;
            securityServerClient.updatePrincipalAttribute(name, soapAttribute);

            // update the passsword

            if (password != null && password.length() > 0 && !password.equals(passwordConfirm))
            {
                addFieldError("password", getText("principal.passwordconfirm.nomatch"));
                addFieldError("confirmPassword", "");

            }
            else if (password != null && password.length() > 0 && password.equals(passwordConfirm))
            {
                PasswordCredential credentials = new PasswordCredential(password);

                securityServerClient.updatePrincipalCredential(name, credentials);
            }

            // populate our memberships for the view page
            super.doDefault();

            return SUCCESS;

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    public String doAddGroup()
    {
        try
        {
            processGeneral();

            // trap the error message because we still want to get the group mappings processed for the view page
            if (unsubscribedGroup != null && unsubscribedGroup.length() > 0)
            {
                try
                {
                    securityServerClient.addPrincipalToGroup(name, unsubscribedGroup);

                }
                catch (ApplicationPermissionException e)
                {
                    addActionError(e.getMessage());
                    logger.debug(e.getMessage(), e);
                }
            }

            // populate our memberships for the view page
            processMemberships();

            return SUCCESS;

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    public String doRemoveGroup()
    {
        try
        {
            processGeneral();

            // add the principal to the group
            if (removeGroup != null && removeGroup.length() > 0)
            {
                securityServerClient.removePrincipalFromGroup(name, removeGroup);
            }

            // populate our memberships for the view page
            processMemberships();

            return SUCCESS;

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    public String doRemoveRole()
    {
        try
        {
            processGeneral();

            // add the principal to the group
            if (removeRole != null && removeRole.length() > 0)
            {
                securityServerClient.removePrincipalFromRole(name, removeRole);
            }

            // populate our memberships for the view page
            processMemberships();

            return SUCCESS;

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    public String doAddRole()
    {
        try
        {
            processGeneral();

            // trap the error message because we still want to get the group mappings processed for the view page
            if (unsubscribedRole != null && unsubscribedRole.length() > 0)
            {
                try
                {
                    securityServerClient.addPrincipalToRole(name, unsubscribedRole);

                }
                catch (ApplicationPermissionException e)
                {
                    addActionError(e.getMessage());
                    logger.debug(e.getMessage(), e);
                }
            }

            // populate our memberships for the view page
            processMemberships();

            return SUCCESS;

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    public String doRemoveAttribute()
    {
        try
        {

            try
            {
                securityServerClient.removeAttributeFromPrincipal(name, attribute);

                // clean up the value for the view page, otherwise it displays this value
                attribute = "";

                // still need to continue processing the rest of the principal even though the remove failed
            }
            catch (ApplicationPermissionException e)
            {
                addActionError(e.getMessage());
                logger.debug(e.getMessage(), e);
            }

            processGeneral();
            processMemberships();

            return SUCCESS;

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    public String doAddAttribute()
    {
        try
        {

            // do not perform the add if it isn't necessary
            if (attribute != null && attribute.length() > 0)
            {

                try
                {
                    SOAPPrincipal principal = securityServerClient.findPrincipalByName(name);

                    // check if the attribute already exist, if it does we'll add to it
                    SOAPAttribute[] attributes = principal.getAttributes();
                    SOAPAttribute existingAttribute = null;
                    for (int i = 0; i < attributes.length; i++)
                    {
                        if (attributes[i].getName().equals(attribute))
                        {
                            existingAttribute = attributes[i];
                            break;
                        }
                    }

                    // attribute doesn't exist, add
                    if (existingAttribute == null)
                    {
                        SOAPAttribute newAttribute = buildAttribute(attribute, value);
                        securityServerClient.addAttributeToPrincipal(name, newAttribute);

                    }
                    else
                    {
                        // attribute already exist, add to existing name
                        List newValues = new ArrayList();
                        newValues.addAll(Arrays.asList(existingAttribute.getValues()));
                        newValues.add(value);

                        // convert back to a soap safe object type
                        SOAPAttribute updatedAttribute = buildAttribute(attribute, (String[]) newValues.toArray(new String[newValues.size()]));

                        // update!
                        securityServerClient.updatePrincipalAttribute(name, updatedAttribute);
                    }

                    // clean up the value for the view page, otherwise it displays these values.
                    attribute = "";
                    value = "";

                    // still need to continue processing the rest of the principal even though the remove failed
                }
                catch (Exception e)
                {
                    addActionError(e.getMessage());
                    logger.debug(e.getMessage(), e);
                }

            }

            processGeneral();
            processMemberships();

            return SUCCESS;

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    public String doUpdateAttributes()
    {
        try
        {

            try
            {
                for (int i = 0; i < attributes.length; i++)
                {
                    String attribute = attributes[i];
                    String values[] = getAttributeValues(attribute);

                    SOAPAttribute updatedAttribute = buildAttribute(attribute, values);

                    securityServerClient.updatePrincipalAttribute(name, updatedAttribute);
                }

                // still need to continue processing the rest of the principal even though the remove failed
            }
            catch (Exception e)
            {
                addActionError(e.getMessage());
                logger.debug(e.getMessage(), e);
            }

            processGeneral();
            processMemberships();

            return SUCCESS;

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return INPUT;
    }

    private String[] getAttributeValues(String attribute)
    {

        // find out how many values there are
        int parameterCount = getParameterCount(attribute);

        // construct the values
        String values[] = new String[parameterCount];
        for (int i = 0; i < parameterCount; i++)
        {
            values[i] = ServletActionContext.getRequest().getParameter(attribute + (i + 1));
        }

        // our return ticket
        return values;
    }

    private int getParameterCount(String attribute)
    {
        int count = 0;

        logger.debug("searching attribute: " + attribute);

        Enumeration parameterNames = ServletActionContext.getRequest().getParameterNames();

        while (parameterNames.hasMoreElements())
        {
            String parameterName = (String) parameterNames.nextElement();
            if (parameterName.matches("(" + attribute + "){1}\\d+"))
            {
                String number = parameterName.substring(attribute.length());

                // match the larger value
                int current = Integer.parseInt(number);
                if (current > count)
                {
                    count = current;
                }
            }
        }

        return count;
    }

    public String getRemoveGroup()
    {
        return removeGroup;
    }

    public void setRemoveGroup(String removeGroup)
    {
        this.removeGroup = removeGroup;
    }

    public String getUnsubscribedGroup()
    {
        return unsubscribedGroup;
    }

    public void setUnsubscribedGroup(String unsubscribedGroup)
    {
        this.unsubscribedGroup = unsubscribedGroup;
    }

    public String getRemoveRole()
    {
        return removeRole;
    }

    public void setRemoveRole(String removeRole)
    {
        this.removeRole = removeRole;
    }

    public String getUnsubscribedRole()
    {
        return unsubscribedRole;
    }

    public void setUnsubscribedRole(String unsubscribedRole)
    {
        this.unsubscribedRole = unsubscribedRole;
    }

    public String getAttribute()
    {
        return attribute;
    }

    public void setAttribute(String attribute)
    {
        this.attribute = attribute;
    }

    public String getValue()
    {
        return value;
    }

    public void setValue(String value)
    {
        this.value = value;
    }

    public String[] getAttributes()
    {
        return attributes;
    }

    public void setAttributes(String[] attributes)
    {
        this.attributes = attributes;
    }
}