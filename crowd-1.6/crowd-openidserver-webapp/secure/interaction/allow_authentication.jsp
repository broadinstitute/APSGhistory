<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/webwork" prefix="ww" %>
<html>
    <head>
        <title><ww:property value="getText('allow.auth.title')"/></title>
        <meta name="section" content="home" />
        <meta name="subsection" content="approvedsites" />
        <meta name="openidauthmode" content="true" /> 

<script type="text/javascript">

    /***************************************************************
     *
     *  Javascript
     *
     ***************************************************************/

    // take the user to the selected profile
    function profileChange()
    {
        var select_menu = document.getElementById('profileID');
        var profile_id = select_menu.options[select_menu.selectedIndex].value;
        location.href = '<ww:url namespace="/secure/interaction" action="allowauthentication" method="doDefault" includeParams="none"/>?profileID='+profile_id;
    }

</script>            

    </head>

    <body>        

        <div class="crowdForm">
            <div class="formTitle">
                <h2><ww:property value="getText('allow.auth.title')"/></h2>
            </div>

            <div class="formBodyNoTop">

                <div class="interactionButtons">
                    <div class="interactionButton">
                        <a id="allow" class="interactionButton" href="<ww:url action="allowauthentication" method="doAllow"><ww:param name="profileID" value="profileID"/></ww:url>" title="<ww:property value="getText('allow.once.text')"/>">
                            <img class="interactionButton" src="<ww:url value="/images/icons/allow_once.png"/>" alt="<ww:property value="getText('allow.once.text')"/>"/>
                            <ww:property value="getText('allow.once.label')"/>
                        </a>
                    </div>
                    <div class="interactionButton">
                        <a id="allowAlways" class="interactionButton" href="<ww:url action="allowauthentication" method="doAllowAlways"><ww:param name="profileID" value="profileID"/></ww:url>" title="<ww:property value="getText('allow.always.text')"/>">
                            <img class="interactionButton" src="<ww:url value="/images/icons/allow_always.png"/>" alt="<ww:property value="getText('allow.allowalways.text')"/>"/>
                            <ww:property value="getText('allow.always.label')"/>
                        </a>
                    </div>
                    <div class="interactionButton">
                        <a id="deny" class="interactionButton" href="<ww:url action="allowauthentication" method="doDeny"/>" title="<ww:property value="getText('allow.deny.text')"/>">
                            <img class="interactionButton" src="<ww:url value="/images/icons/deny.png"/>" alt="<ww:property value="getText('allow.deny.label')"/>"/>
                            <ww:property value="getText('allow.deny.label')"/>
                        </a>
                    </div>
                </div>

                <p>
                    <ww:property value="getText('allow.requestingsite.label')"/>
                    <div class="whiteblock" id="requestingSite">
                        <ww:property value="requestingSite"/>
                    </div>
                </p>

                <p>
                    <ww:property value="getText('allow.confirmation.label')"/>
                    <div class="whiteblock" id="requestingIdentity">
                        <ww:property value="identifier"/>
                    </div>
                </p>

                <ww:if test="requiredAttributes.size + optionalAttributes.size > 0">
                    <p>
                        <ww:property value="getText('allow.datarequest.label')"/>
                        <div class="whiteblock" id="requestingAttributes">
                            <ww:iterator value="requiredAttributes">
                                <ww:property/> &nbsp;
                            </ww:iterator>
                            <ww:iterator value="optionalAttributes">
                                <ww:property/> &nbsp;
                            </ww:iterator>
                        </div>
                    </p>
                </ww:if>    

                <br/>
                
            </div>

            <div class="titleSection">
                <ww:property value="getText('allow.selectprofile.label')"/>
            </div>

            <div class="formBody">

                <ww:select id="profileID" name="profileID" list="user.profiles" listValue="name" listKey="id" value="currentProfile.id" onchange="profileChange();">
                    <ww:param name="label" value="'Use this profile'"/>
                </ww:select>

                <ww:if test="currentProfile.attributes.size > 0">
                    <table class="attributeTable" id="attributeTable" width="580" style="width: 580px;">

                        <ww:if test="sregAttributes.nickname != null">
                            <tr class="attributeCellFirst" width="250px">
                                <td class="attributeCellFirst" width="250px">
                                    <ww:text name="sreg.nickname.label"/>
                                </td>
                                <td class="attributeCell" colspan="2">
                                    <ww:property value="sregAttributes.nickname"/>
                                </td>
                            </tr>
                        </ww:if>

                        <ww:if test="sregAttributes.fullname != null">
                            <tr class="attributeCellFirst" width="250px">
                                <td class="attributeCellFirst" width="250px">
                                    <ww:text name="sreg.fullname.label"/>
                                </td>
                                <td class="attributeCell" colspan="2">
                                    <ww:property value="sregAttributes.fullname"/>
                                </td>
                            </tr>
                        </ww:if>

                        <ww:if test="sregAttributes.email != null">
                            <tr class="attributeCellFirst" width="250px">
                                <td class="attributeCellFirst" width="250px">
                                    <ww:text name="sreg.email.label"/>
                                </td>
                                <td class="attributeCell" colspan="2">
                                    <ww:property value="sregAttributes.email"/>
                                </td>
                            </tr>
                        </ww:if>

                        <ww:if test="sregAttributes.dob != null">
                            <tr class="attributeCellFirst" width="250px">
                                <td class="attributeCellFirst" width="250px">
                                    <ww:text name="sreg.dob.label"/>
                                </td>
                                <td class="attributeCell" colspan="2">
                                    <ww:property value="profileAttributesHelper.getNiceDate(sregAttributes.dob)"/>
                                </td>
                            </tr>
                        </ww:if>

                        <ww:if test="sregAttributes.gender != null">
                            <tr class="attributeCellFirst" width="250px">
                                <td class="attributeCellFirst" width="250px">
                                    <ww:text name="sreg.gender.label"/>
                                </td>
                                <td class="attributeCell" colspan="2">
                                    <ww:property value="profileAttributesHelper.getGenders().get(sregAttributes.gender)"/>
                                </td>
                            </tr>
                        </ww:if>

                        <ww:if test="sregAttributes.postcode != null">
                            <tr class="attributeCellFirst" width="250px">
                                <td class="attributeCellFirst" width="250px">
                                    <ww:text name="sreg.postcode.label"/>
                                </td>
                                <td class="attributeCell" colspan="2">
                                    <ww:property value="sregAttributes.postcode"/>
                                </td>
                            </tr>
                        </ww:if>

                        <ww:if test="sregAttributes.country != null">
                            <tr class="attributeCellFirst" width="250px">
                                <td class="attributeCellFirst" width="250px">
                                    <ww:text name="sreg.country.label"/>
                                </td>
                                <td class="attributeCell" colspan="2">
                                    <ww:property value="profileAttributesHelper.getCountries().get(sregAttributes.country)"/>
                                </td>
                            </tr>
                        </ww:if>

                        <ww:if test="sregAttributes.timezone != null">
                            <tr class="attributeCellFirst" width="250px">
                                <td class="attributeCellFirst" width="250px">
                                    <ww:text name="sreg.timezone.label"/>
                                </td>
                                <td class="attributeCell" colspan="2">
                                    <ww:property value="sregAttributes.timezone"/>
                                </td>
                            </tr>
                        </ww:if>

                        <ww:if test="sregAttributes.language != null">
                            <tr class="attributeCellFirst" width="250px">
                                <td class="attributeCellFirst" width="250px">
                                    <ww:text name="sreg.language.label"/>
                                </td>
                                <td class="attributeCell" colspan="2">
                                    <ww:property value="profileAttributesHelper.getLanguages().get(sregAttributes.language)"/>
                                </td>
                            </tr>
                        </ww:if>

                    </table>
                </ww:if>
                <ww:else>
                    <p><ww:property value="getText('allow.noprofileattributes.label')"/></p>
                </ww:else>
                

            </div>
        </div>
    
    </body>
</html>