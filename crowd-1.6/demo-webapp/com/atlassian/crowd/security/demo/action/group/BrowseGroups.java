/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action.group;

import com.atlassian.crowd.integration.SearchContext;
import com.atlassian.crowd.integration.soap.SOAPGroup;
import com.atlassian.crowd.integration.soap.SearchRestriction;
import com.atlassian.crowd.security.demo.action.AbstractBrowser;

import java.util.Arrays;
import java.util.List;
import java.util.ArrayList;

import org.apache.commons.lang.StringUtils;

public class BrowseGroups extends AbstractBrowser
{

    private String active;
    private String name;

    public String execute()
    {
        try
        {
            // build our search attributes
            List<SearchRestriction> searchRestrictions = new ArrayList<SearchRestriction>();

            // restrict by the active status
            if (StringUtils.isNotBlank(active))
            {
                searchRestrictions.add(new SearchRestriction(SearchContext.GROUP_ACTIVE, active));
            }

            // restrict by the name
            if (StringUtils.isNotBlank(name))
            {
                searchRestrictions.add(new SearchRestriction(SearchContext.GROUP_NAME, name));
            }

            // we do not need the membership data, also available: "all", "direct"
            searchRestrictions.add(new SearchRestriction(SearchContext.GROUP_POPULATE_MEMBERSHIPS, "none"));

            // where we will star the search from in the results set
            searchRestrictions.add(new SearchRestriction(SearchContext.SEARCH_INDEX_START, Long.toString(resultsStart)));

            // the max number of results to return
            searchRestrictions.add(new SearchRestriction(SearchContext.SEARCH_MAX_RESULTS, Long.toString(resultsPerPage + 1)));

            // run the search
            SOAPGroup[] soapGroups = securityServerClient.searchGroups(searchRestrictions.toArray(new SearchRestriction[searchRestrictions.size()]));

            results = Arrays.asList(soapGroups);

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

    public String getName()
    {
        return name;
    }

    public void setName(String name)
    {
        this.name = name;
    }
}