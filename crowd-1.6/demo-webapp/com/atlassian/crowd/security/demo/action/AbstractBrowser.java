/*
 * Copyright (c) 2005 Authentisoft, LLC. All Rights Reserved.
 */
package com.atlassian.crowd.security.demo.action;

import java.util.List;

public abstract class AbstractBrowser extends BaseAction
{

    /**
     * Results start.
     */
    protected int resultsStart = 0;
    /**
     * Results per page.
     */
    protected int resultsPerPage = 10;
    /**
     * Results listObjects.
     */
    protected List results = null;

    /**
     * Gets the results start.
     *
     * @return the results start.
     */
    public int getResultsStart()
    {
        return resultsStart;
    }

    /**
     * Sets the results start.
     *
     * @param resultsStart the results start.
     */
    public void setResultsStart(int resultsStart)
    {
        this.resultsStart = resultsStart;
    }

    /**
     * Gets the next results start.
     *
     * @return the next results start.
     */
    public int getNextResultsStart()
    {
        return resultsStart + resultsPerPage;
    }

    /**
     * Gets the previous results start.
     *
     * @return the previous results start.
     */
    public int getPreviousResultsStart()
    {
        int result = resultsStart - resultsPerPage;

        if (result < 0)
        {
            return 0;
        }
        else
        {
            return result;
        }
    }

    /**
     * Gets the results per page.
     *
     * @return the results per page.
     */
    public int getResultsPerPage()
    {
        return resultsPerPage;
    }

    /**
     * Sets the results per page.
     *
     * @param resultsPerPage the results per page.
     */
    public void setResultsPerPage(int resultsPerPage)
    {
        this.resultsPerPage = resultsPerPage;
    }

    public List getResults()
    {
        return results;
    }

    public void setResults(List results)
    {
        this.results = results;
    }
}