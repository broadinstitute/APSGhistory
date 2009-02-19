<map version="0.8.1">
<!-- To view this file, download free mind mapping software FreeMind from http://freemind.sourceforge.net -->
<node CREATED="1234925812547" ID="Freemind_Link_1145983366" MODIFIED="1234926343700" TEXT="Csh Startup">
<node CREATED="1234926343691" ID="Freemind_Link_202448406" MODIFIED="1234926498239" POSITION="right" TEXT="login shell startup &#xa;(complie option dependent)">
<node CREATED="1234926071898" ID="_" MODIFIED="1234926136171" TEXT="/etc/csh.cshrc">
<node CREATED="1234926607153" ID="Freemind_Link_349864690" MODIFIED="1234926613652" TEXT="Machine Dependent"/>
</node>
<node CREATED="1234926137039" ID="Freemind_Link_1760740726" MODIFIED="1234926148178" TEXT="/etc/csh.login">
<node CREATED="1234926615457" ID="Freemind_Link_90052515" MODIFIED="1234926621212" TEXT="Machine Dependent"/>
</node>
<node CREATED="1234926150678" ID="Freemind_Link_279317626" MODIFIED="1234926165058" TEXT="one of (in order)">
<node CREATED="1234926165535" ID="Freemind_Link_1737668585" MODIFIED="1234926178890" TEXT="~/.tcshrc">
<node CREATED="1234926645433" ID="Freemind_Link_47131868" MODIFIED="1234926648679" TEXT="not in my ~"/>
</node>
<node CREATED="1234926179575" ID="Freemind_Link_489361853" MODIFIED="1234926186090" TEXT="~/.cshrc">
<node CREATED="1234926651721" ID="Freemind_Link_1970028289" MODIFIED="1234926676564" TEXT="/util/etc/setup_csh">
<node CREATED="1234926802525" ID="Freemind_Link_1191430814" MODIFIED="1234926814249" TEXT="eval `/broad/tools/dotkit/init`"/>
<node CREATED="1234926814734" ID="Freemind_Link_1140586527" MODIFIED="1234926824697" TEXT="set path=( /util/bin /util/sbin /usr/bin /bin /usr/X11R6/bin /usr/bin/X11 /usr/sbin /sbin /util/oracle/bin ) "/>
<node CREATED="1234926830710" ID="Freemind_Link_383951608" MODIFIED="1234926843849" TEXT="setenv MANPATH /util/man:/usr/man:/usr/local/man:/usr/opt/networker/man:/opt/csm/man:/usr/share/man"/>
<node CREATED="1234926844630" ID="Freemind_Link_223805300" MODIFIED="1234926853137" TEXT="setenv LD_LIBRARY_PATH /util/lib:/util/oracle/lib:/usr/local/lib:/usr/lib:/lib:/util/lib64"/>
<node CREATED="1234926855622" ID="Freemind_Link_315789847" MODIFIED="1234926871746" TEXT="setenv ORACLE_HOME /util/oracle"/>
<node CREATED="1234926872470" ID="Freemind_Link_1401031885" MODIFIED="1234926882225" TEXT="alias orasetup source /util/bin/coraenv"/>
<node CREATED="1234926883086" ID="Freemind_Link_704869888" MODIFIED="1234926922601" TEXT="alias ish &apos;bsub -Is -q interactive tcsh&apos; &#xa;alias isub &apos;bsub -Is -q interactive &apos; &#xa;alias finger &apos;finger -M&apos; &#xa;alias quota &apos;quota -sQ&apos; &#xa;alias gosolrun &apos;cd `/seq/software/bin/goSolexaRun.pl \!*`&apos; "/>
<node CREATED="1234926929174" ID="Freemind_Link_1699163705" MODIFIED="1234926960473" TEXT="setenv ORGANIZATION &quot;Broad Institute of MIT and Harvard&quot; &#xa;setenv DOMAINNAME &quot;broad.mit.edu&quot; "/>
<node CREATED="1234926976399" ID="Freemind_Link_1882475345" MODIFIED="1234927021636" TEXT="if (! $?HOST) then&#xa; &#x9;setenv HOST `hostname` &#xa;endif &#xa;setenv HOSTNAME $HOST "/>
<node CREATED="1234926996231" ID="Freemind_Link_526457434" MODIFIED="1234927035139" TEXT="setenv LANG C"/>
<node CREATED="1234927037465" ID="Freemind_Link_872702430" MODIFIED="1234927047362" TEXT="setenv LM_LICENSE_FILE /usr/lib/nag/license.dat"/>
<node CREATED="1234927062647" ID="Freemind_Link_68758818" MODIFIED="1234927064619" TEXT="source /broad/lsf/conf/cshrc.lsf"/>
<node CREATED="1234927076688" ID="Freemind_Link_598598210" MODIFIED="1234927078219" TEXT="source /usr/intel/compiler81/bin/iccvars.csh"/>
</node>
<node CREATED="1234926677097" ID="Freemind_Link_1624843541" MODIFIED="1234926728449" TEXT="if (! $?group) then&#xa;&#x9;set groups=`groups`&#xa;&#x9;set group=$groups[1]&#xa;endif&#xa;"/>
<node CREATED="1234926731685" ID="Freemind_Link_1064651716" MODIFIED="1234926755218" TEXT="/util/etc/$group.setup_csh"/>
<node CREATED="1234926755805" ID="Freemind_Link_17944816" MODIFIED="1234926768281" TEXT="$HOME/.my.cshrc"/>
</node>
</node>
<node CREATED="1234926201640" ID="Freemind_Link_1172282382" MODIFIED="1234926232675" TEXT="~/.history (or histfile variable value)"/>
<node CREATED="1234926234031" ID="Freemind_Link_685065005" MODIFIED="1234926247795" TEXT="~/.login"/>
<node CREATED="1234926248528" ID="Freemind_Link_1270329469" MODIFIED="1234926277811" TEXT="~/cshdirs (or dirsfile variable value)"/>
</node>
<node CREATED="1234926502776" ID="Freemind_Link_1410252318" MODIFIED="1234926520934" POSITION="left" TEXT="non-login shell">
<node CREATED="1234926523423" ID="Freemind_Link_547912309" MODIFIED="1234926532060" TEXT="/etc/csh.cshrc"/>
<node CREATED="1234926534600" ID="Freemind_Link_1418700624" MODIFIED="1234926555260" TEXT="one of (in order)">
<node CREATED="1234926165535" ID="Freemind_Link_872621937" MODIFIED="1234926178890" TEXT="~/.tcshrc">
<node CREATED="1234926645433" ID="Freemind_Link_887707295" MODIFIED="1234926648679" TEXT="not in my ~"/>
</node>
<node CREATED="1234926179575" ID="Freemind_Link_537936163" MODIFIED="1234926186090" TEXT="~/.cshrc">
<node CREATED="1234926651721" ID="Freemind_Link_519517810" MODIFIED="1234926676564" TEXT="/util/etc/setup_csh">
<node CREATED="1234926802525" ID="Freemind_Link_222949561" MODIFIED="1234926814249" TEXT="eval `/broad/tools/dotkit/init`"/>
<node CREATED="1234926814734" ID="Freemind_Link_1862220970" MODIFIED="1234926824697" TEXT="set path=( /util/bin /util/sbin /usr/bin /bin /usr/X11R6/bin /usr/bin/X11 /usr/sbin /sbin /util/oracle/bin ) "/>
<node CREATED="1234926830710" ID="Freemind_Link_1763355115" MODIFIED="1234926843849" TEXT="setenv MANPATH /util/man:/usr/man:/usr/local/man:/usr/opt/networker/man:/opt/csm/man:/usr/share/man"/>
<node CREATED="1234926844630" ID="Freemind_Link_1863863965" MODIFIED="1234926853137" TEXT="setenv LD_LIBRARY_PATH /util/lib:/util/oracle/lib:/usr/local/lib:/usr/lib:/lib:/util/lib64"/>
<node CREATED="1234926855622" ID="Freemind_Link_1093624751" MODIFIED="1234926871746" TEXT="setenv ORACLE_HOME /util/oracle"/>
<node CREATED="1234926872470" ID="Freemind_Link_72777286" MODIFIED="1234926882225" TEXT="alias orasetup source /util/bin/coraenv"/>
<node CREATED="1234926883086" ID="Freemind_Link_1210220135" MODIFIED="1234926922601" TEXT="alias ish &apos;bsub -Is -q interactive tcsh&apos; &#xa;alias isub &apos;bsub -Is -q interactive &apos; &#xa;alias finger &apos;finger -M&apos; &#xa;alias quota &apos;quota -sQ&apos; &#xa;alias gosolrun &apos;cd `/seq/software/bin/goSolexaRun.pl \!*`&apos; "/>
<node CREATED="1234926929174" ID="Freemind_Link_173699596" MODIFIED="1234926960473" TEXT="setenv ORGANIZATION &quot;Broad Institute of MIT and Harvard&quot; &#xa;setenv DOMAINNAME &quot;broad.mit.edu&quot; "/>
<node CREATED="1234926976399" ID="Freemind_Link_817121684" MODIFIED="1234927021636" TEXT="if (! $?HOST) then&#xa; &#x9;setenv HOST `hostname` &#xa;endif &#xa;setenv HOSTNAME $HOST "/>
<node CREATED="1234926996231" ID="Freemind_Link_782317992" MODIFIED="1234927035139" TEXT="setenv LANG C"/>
<node CREATED="1234927037465" ID="Freemind_Link_584122794" MODIFIED="1234927047362" TEXT="setenv LM_LICENSE_FILE /usr/lib/nag/license.dat"/>
<node CREATED="1234927062647" ID="Freemind_Link_1088486109" MODIFIED="1234927064619" TEXT="source /broad/lsf/conf/cshrc.lsf"/>
<node CREATED="1234927076688" ID="Freemind_Link_1810192937" MODIFIED="1234927078219" TEXT="source /usr/intel/compiler81/bin/iccvars.csh"/>
</node>
<node CREATED="1234926677097" ID="Freemind_Link_1903167051" MODIFIED="1234926728449" TEXT="if (! $?group) then&#xa;&#x9;set groups=`groups`&#xa;&#x9;set group=$groups[1]&#xa;endif&#xa;"/>
<node CREATED="1234926731685" ID="Freemind_Link_1398675840" MODIFIED="1234926755218" TEXT="/util/etc/$group.setup_csh"/>
<node CREATED="1234926755805" ID="Freemind_Link_1219702112" MODIFIED="1234926768281" TEXT="$HOME/.my.cshrc"/>
</node>
</node>
</node>
</node>
</map>
