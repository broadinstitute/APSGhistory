<%--
  -- WebWork, Web Application Framework
  --
  -- Distributable under LGPL license.
  -- See terms of license at opensource.org
  --
  --
  -- hidden.jsp
  --
  -- Required Parameters:
  --   * name       - The name of the attribute to put and pull the result from.
  --                  Equates to the NAME parameter of the HTML INPUT tag.
  --
  -- Optional Parameters:
  --
  --%>
<%@ taglib uri="/webwork" prefix="webwork" %>

<input type="hidden"
       name="<webwork:property value="parameters['name']"/>"
         <webwork:if test="parameters['nameValue'] != null">value="<webwork:property value="parameters['nameValue']"/>"</webwork:if>
         <webwork:if test="parameters['id'] != null">id="<webwork:property value="parameters['id']"/>"</webwork:if>
        />
