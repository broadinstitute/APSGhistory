/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action.role;

import com.atlassian.crowd.integration.SearchContext;
import com.atlassian.crowd.integration.soap.SOAPRole;
import com.atlassian.crowd.integration.soap.SearchRestriction;
import com.atlassian.crowd.security.demo.action.AbstractBrowser;
import org.apache.log4j.Logger;

import java.util.Arrays;

public class BrowseRoles extends AbstractBrowser {
    private static final Logger logger = Logger.getLogger(BrowseRoles.class);

    private String active;
    private String name;

    public String execute() {
        try {
            // build our search attributes
            SearchRestriction[] searchRestrictions = {new SearchRestriction(), new SearchRestriction(),
                    new SearchRestriction(), new SearchRestriction(), new SearchRestriction()};

            // restrict by the active status
            searchRestrictions[0].setName(SearchContext.ROLE_ACTIVE);
            searchRestrictions[0].setValue(active);

            // restrict by the name
            searchRestrictions[1].setName(SearchContext.ROLE_NAME);
            searchRestrictions[1].setValue(name);

            // we do not need the membership data
            searchRestrictions[2].setName(SearchContext.ROLE_POPULATE_MEMBERSHIPS);
            searchRestrictions[2].setValue("none");     // can also be "direct" or "all"

            // where we will star the search from in the results set
            searchRestrictions[3].setName(SearchContext.SEARCH_INDEX_START);
            searchRestrictions[3].setValue(Long.toString(resultsStart));

            // the max number of results to return
            searchRestrictions[4].setName(SearchContext.SEARCH_MAX_RESULTS);
            searchRestrictions[4].setValue(Long.toString(resultsPerPage + 1));

            // run the search
            SOAPRole[] soapRoles = securityServerClient.searchRoles(searchRestrictions);

            results = Arrays.asList(soapRoles);

        } catch (Exception e) {
            addActionError(e.getMessage());
            logger.debug(e.getMessage(), e);

        }

        return SUCCESS;
    }

    public String getActive() {
        return active;
    }

    public void setActive(String active) {
        this.active = active;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }
}