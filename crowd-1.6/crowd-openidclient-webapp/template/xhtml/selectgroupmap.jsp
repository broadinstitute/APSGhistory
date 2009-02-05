<%--
  -- WebWork, Web Application Framework
  --
  -- Distributable under LGPL license.
  -- See terms of license at opensource.org
  --
  --
  -- selectgroupmap.jsp
  --
  -- Required Parameters:
  --   * label     - The description that will be used to identfy the control.
  --   * name      - The name of the attribute to put and pull the result from.
  --                 Equates to the NAME parameter of the HTML tag SELECT.
  --   * list      - Iterator that will provide the options for the control.
  --                 Equates to the HTML OPTION tags in the SELECT.
  --   * groupKey  - Where to get the values for the OPTGROUP tag.  Equates to
  --                 the LABEL parameter of the OPTION tag.
  --   * groupList - Iterator that will provide the options for the role.
  --                 Must refer to an attribute of the "list" parameter elements
  --   * listKey   - Where to get the values for the OPTION tag.  Equates to
  --                 the VALUE parameter of the OPTION tag.
  --   * listValue - The value displayed by the control.  Equates to the body
  --                 of the HTML OPTION tag.
  --
  -- Optional Parameters:
  --   * labelposition   - determines were the label will be place in relation
  --                       to the control.  Default is to the left of the control.
  --   * disabled        - DISABLED parameter of the HTML SELECT tag.
  --   * tabindex        - tabindex parameter of the HTML SELECT tag.
  --   * onchange        - onkeyup parameter of the HTML SELECT tag.
  --   * size            - SIZE parameter of the HTML SELECT tag.
  --   * multiple        - MULTIPLE parameter of the HTML SELECT tag.
  --   * headerKey       - Combined with headerValue parameter specifies the top of select list
  --   * headerValue     - see above
  --
  --%>
<%@ taglib uri="/webwork" prefix="webwork" %>
<%@ include file="controlheader.jsp" %>
<select name="<webwork:property value="parameters['name']"/>"
         <webwork:if test="parameters['disabled'] == true">disabled="disabled"</webwork:if>
         <webwork:if test="parameters['tabindex']">tabindex="<webwork:property value="parameters['tabindex']"/>"</webwork:if>
         <webwork:if test="parameters['onchange']">onchange="<webwork:property value="parameters['onchange']"/>"</webwork:if>
         <webwork:if test="parameters['size']">size="<webwork:property value="parameters['size']"/>"</webwork:if>
         <webwork:if test="parameters['multiple'] == true">multiple="multiple"</webwork:if>
         <webwork:if test="parameters['id']">id="<webwork:property value="parameters['id']"/>"</webwork:if>
>
   <webwork:if test="parameters['headerKey'] != null && parameters['headerValue'] != null">
      <option value="<webwork:property value="parameters['headerKey']"/>">
         <webwork:property value="parameters['headerValue']"/>
      </option>
   </webwork:if>
   <webwork:iterator value="parameters['list']">
      <optgroup label="<webwork:property value="{parameters['groupKey']}"/>">
         <webwork:iterator value="{parameters['groupList']}">
            <option value="<webwork:property value="{parameters['listKey']}"/>"
               <webwork:if test="{memberOf(parameters['nameValue'], {parameters['listKey']})} == true">selected="selected"</webwork:if>
            >
               <webwork:property value="{parameters['listValue']}"/>
            </option>
         </webwork:iterator>
      </optgroup>
   </webwork:iterator>
</select>

<%@ include file="controlfooter.jsp" %>