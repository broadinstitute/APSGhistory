<%--
  -- WebWork, Web Application Framework
  --
  -- Distributable under LGPL license.
  -- See terms of license at opensource.org
  --
  --
  -- tabbedpane.jsp	
  --
  -- Required Parameters:
  --   * contentName      - The name of the data map to be used.  
  --
  -- Optional Parameters:
  --   * tabAlign 	-	 The Alignment of the tabs. Default is the CENTER of the control.
  --   * id  				- 	 Id of the control.
  --
  --%>

<%@ taglib uri="/webwork" prefix="webwork" %>

<webwork:bean name="'webwork.util.Counter'" id="tabIndex">
	<webwork:param name="'first'" value="0"/>
	<webwork:param name="'last'" value="content/size"/>
</webwork:bean>
			
<table border="1" cellspacing="0" cellpadding="5" id="<webwork:property value="id"/>">

	<tr valign="bottom" align="<webwork:property value="tabAlign"/>">

		<webwork:if test="tabAlign == 'CENTER' || tabAlign == 'RIGHT'"><th colspan ="1" width="*"></th></webwork:if>

		<webwork:iterator value="content">
			<th width="10%"
				<webwork:if id="isCur" test="selectedIndex == @tabIndex/current">bgcolor="#A0B3FC"</webwork:if>
				<webwork:else>bgcolor="#C0C0C0"</webwork:else>>
				<a href="<webwork:url><webwork:param name="indexLink" value="@tabIndex/next"/></webwork:url>">
				<webwork:if test="@isCur == true"><em></webwork:if>
					<webwork:property value="key"/>
				<webwork:if test="@isCur == true"></em></webwork:if>
				</a>
			</th>		
		</webwork:iterator>
		
		<webwork:if test="tabAlign == 'CENTER' || tabAlign == 'LEFT'"><th colspan ="1" width="*"></th></webwork:if>
	
	</tr>
	<tr>
		<td bgcolor="#E1EAE8" colspan="<webwork:property value="colSpanLength"/>" width="100%">
			<webwork:include value="selectedUrl"/>
		</td>
	</tr>
</table>