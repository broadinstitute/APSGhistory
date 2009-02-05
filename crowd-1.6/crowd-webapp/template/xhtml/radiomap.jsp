<%--
  -- WebWork, Web Application Framework
  --
  -- Distributable under LGPL license.
  -- See terms of license at opensource.org
  --
  --
  -- radiomap.jsp
  --
  -- Required Parameters:
  --   * label     - The description that will be used to identfy the control.
  --   * name      - The name of the attribute to put and pull the result from.
  --                 Equates to the NAME parameter of the HTML tag INPUT.
  --   * list      - Iterator that will provide the options for the control.
  --                 Equates to the HTML LABEL tags.
  --   * listKey   - Where to get the values for the INPUT tag.  Equates to
  --                 the VALUE parameter of the INPUT tag.
  --   * listValue - The value displayed next to the radio control.  Equates to the body
  --                 of the enclosing HTML LABEL tag.
  --
  -- Optional Parameters:
  --   * labelposition   - determines were the label will be place in relation
  --                       to the control.  Default is to the left of the control.
  --   * disabled        - DISABLED parameter of the HTML INPUT tag.
  --   * tabindex        - tabindex parameter of the HTML INPUT tag.
  --   * onchange        - onkeyup parameter of the HTML INPUT tag.
  --
  --%>
<%@ taglib uri="/webwork" prefix="webwork" %>
<%@ include file="controlheader.jsp" %>

<webwork:iterator value="parameters.list">
    <webwork:push value="[0]"/>

    <webwork:if test="parameters.listKey != null">
        <webwork:set name="itemKey" value="stack.findString(parameters.listKey)"/>
    </webwork:if>
    <webwork:else>
        <webwork:set name="itemKey" value="[0]"/>
    </webwork:else>

    <webwork:if test="parameters.listValue != null">
        <webwork:set name="itemValue" value="stack.findString(parameters.listValue)"/>
    </webwork:if>
    <webwork:else>
        <webwork:set name="itemValue" value="[0]"/>
    </webwork:else>

    <input type="radio"
            <webwork:if test="parameters['nameValue'] == #itemKey || parameters['selectedValue'] == #itemKey ">checked="checked"</webwork:if>

           name="<webwork:property value="parameters['name']"/>"
           value="<webwork:property value="#itemKey"/>"

            <webwork:if test="parameters['onchange'] != null">onchange="<webwork:property value="parameters['onchange']"/>"</webwork:if>

            />

    <webwork:property value="#itemValue"/>
    <webwork:property value="stack.pop"/>

</webwork:iterator>


<%@ include file="controlfooter.jsp" %>

