/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action.principal;

import com.atlassian.crowd.integration.SearchContext;
import com.atlassian.crowd.integration.model.RemotePrincipalConstants;
import com.atlassian.crowd.integration.soap.SOAPAttribute;
import com.atlassian.crowd.integration.soap.SOAPPrincipal;
import com.atlassian.crowd.integration.soap.SearchRestriction;
import com.atlassian.crowd.security.demo.action.AbstractBrowser;

import java.util.Arrays;

public class BrowsePrincipals extends AbstractBrowser
{

    private String active;
    private String name;
    private String email;

    public String execute()
    {
        try
        {
            // build our search attributes
            SearchRestriction[] searchRestrictions = {new SearchRestriction(), new SearchRestriction(),
                    new SearchRestriction(), new SearchRestriction(), new SearchRestriction()};

            // restrict by the active status
            searchRestrictions[0].setName(SearchContext.PRINCIPAL_ACTIVE);
            searchRestrictions[0].setValue(active);

            // restrict by the name
            searchRestrictions[1].setName(SearchContext.PRINCIPAL_NAME);
            searchRestrictions[1].setValue(name);

            // restrict by the ename
            searchRestrictions[2].setName(SearchContext.PRINCIPAL_EMAIL);
            searchRestrictions[2].setValue(email);

            // where we will star the search from in the results set
            searchRestrictions[3].setName(SearchContext.SEARCH_INDEX_START);
            searchRestrictions[3].setValue(Long.toString(resultsStart));

            // the max number of results to return
            searchRestrictions[4].setName(SearchContext.SEARCH_MAX_RESULTS);
            searchRestrictions[4].setValue(Long.toString(resultsPerPage + 1));

            // run the search
            SOAPPrincipal[] soapPrincipals = securityServerClient.searchPrincipals(searchRestrictions);

            results = Arrays.asList(soapPrincipals);

        }
        catch (Exception e)
        {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);
        }

        return SUCCESS;
    }

    public String getActive()
    {
        return active;
    }

    public void setActive(String active)
    {
        this.active = active;
    }

    public String getEmail()
    {
        return email;
    }

    public void setEmail(String email)
    {
        this.email = email;
    }

    public String getName()
    {
        return name;
    }

    public void setName(String name)
    {
        this.name = name;
    }

    public String getPrincipalEmail(SOAPAttribute[] attributes)
    {
        String principalEmail = null;
        for (int i = 0; i < attributes.length; i++)
        {
            SOAPAttribute attribute = attributes[i];
            if (attribute.getName().equals(RemotePrincipalConstants.EMAIL))
            {
                principalEmail = attribute.getValues()[0];
                break;
            }
        }

        return principalEmail;
    }
}