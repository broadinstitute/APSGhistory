update CONTENT          set USERNAME = REPLACE(USERNAME, '@broadinstitute.org', '') where USERNAME like '%@broadinstitute.org';

update LABEL            set OWNER = REPLACE(OWNER, '@broadinstitute.org', '') where OWNER like '%@broadinstitute.org';
update CONTENT_LABEL    set OWNER = REPLACE(OWNER, '@broadinstitute.org', '') where OWNER like '%@broadinstitute.org';

update SPACEPERMISSIONS set PERMUSERNAME = REPLACE(PERMUSERNAME, '@broadinstitute.org', '') where PERMUSERNAME like '%@broadinstitute.org';

update SPACES           set spacekey = REPLACE(spacekey, '@broadinstitute.org', '') where spacekey like '%@broadinstitute.org';
update CONTENT_LABEL    set spacekey = REPLACE(spacekey, '@broadinstitute.org', '') where spacekey like '%@broadinstitute.org';

update BANDANA          set BANDANACONTEXT = REPLACE(BANDANACONTEXT, '@broadinstitute.org', '') where BANDANACONTEXT like '%@broadinstitute.org';

update ATTACHMENTS      set CREATOR = REPLACE(CREATOR, '@broadinstitute.org', '') where CREATOR like '%@broadinstitute.org';
update CONTENT          set CREATOR = REPLACE(CREATOR, '@broadinstitute.org', '') where CREATOR like '%@broadinstitute.org';
update LINKS            set CREATOR = REPLACE(CREATOR, '@broadinstitute.org', '') where CREATOR like '%@broadinstitute.org';
update NOTIFICATIONS    set CREATOR = REPLACE(CREATOR, '@broadinstitute.org', '') where CREATOR like '%@broadinstitute.org';
update PAGETEMPLATES    set CREATOR = REPLACE(CREATOR, '@broadinstitute.org', '') where CREATOR like '%@broadinstitute.org';
update SPACES           set CREATOR = REPLACE(CREATOR, '@broadinstitute.org', '') where CREATOR like '%@broadinstitute.org';
update EXTRNLNKS        set CREATOR = REPLACE(CREATOR, '@broadinstitute.org', '') where CREATOR like '%@broadinstitute.org';
update SPACEPERMISSIONS set CREATOR = REPLACE(CREATOR, '@broadinstitute.org', '') where CREATOR like '%@broadinstitute.org';
update CONTENTLOCK      set CREATOR = REPLACE(CREATOR, '@broadinstitute.org', '') where CREATOR like '%@broadinstitute.org';
update TRACKBACKLINKS   set CREATOR = REPLACE(CREATOR, '@broadinstitute.org', '') where CREATOR like '%@broadinstitute.org';

update ATTACHMENTS      set lastmodifier = REPLACE(lastmodifier, '@broadinstitute.org', '') where lastmodifier like '%@broadinstitute.org';
update CONTENT          set lastmodifier = REPLACE(lastmodifier, '@broadinstitute.org', '') where lastmodifier like '%@broadinstitute.org';
update EXTRNLNKS        set lastmodifier = REPLACE(lastmodifier, '@broadinstitute.org', '') where lastmodifier like '%@broadinstitute.org';
update LINKS            set lastmodifier = REPLACE(lastmodifier, '@broadinstitute.org', '') where lastmodifier like '%@broadinstitute.org';
update NOTIFICATIONS    set lastmodifier = REPLACE(lastmodifier, '@broadinstitute.org', '') where lastmodifier like '%@broadinstitute.org';
update PAGETEMPLATES    set lastmodifier = REPLACE(lastmodifier, '@broadinstitute.org', '') where lastmodifier like '%@broadinstitute.org';
update SPACES           set lastmodifier = REPLACE(lastmodifier, '@broadinstitute.org', '') where lastmodifier like '%@broadinstitute.org';
update SPACEPERMISSIONS set lastmodifier = REPLACE(lastmodifier, '@broadinstitute.org', '') where lastmodifier like '%@broadinstitute.org';
update CONTENTLOCK      set lastmodifier = REPLACE(lastmodifier, '@broadinstitute.org', '') where lastmodifier like '%@broadinstitute.org';
update TRACKBACKLINKS   set lastmodifier = REPLACE(lastmodifier, '@broadinstitute.org', '') where lastmodifier like '%@broadinstitute.org';

update os_user          set USERNAME = REPLACE(USERNAME, '@broadinstitute.org', '') where USERNAME like '%@broadinstitute.org';

update users            set name = REPLACE(name, '@broadinstitute.org', '') where name like '%@broadinstitute.org';




update CONTENT          set USERNAME = REPLACE(USERNAME, '@broad.mit.edu', '') where USERNAME like '%@broad.mit.edu';

update LABEL            set OWNER = REPLACE(OWNER, '@broad.mit.edu', '') where OWNER like '%@broad.mit.edu';
update CONTENT_LABEL    set OWNER = REPLACE(OWNER, '@broad.mit.edu', '') where OWNER like '%@broad.mit.edu';

update SPACEPERMISSIONS set PERMUSERNAME = REPLACE(PERMUSERNAME, '@broad.mit.edu', '') where PERMUSERNAME like '%@broad.mit.edu';

update SPACES           set spacekey = REPLACE(spacekey, '@broad.mit.edu', '') where spacekey like '%@broad.mit.edu';
update CONTENT_LABEL    set spacekey = REPLACE(spacekey, '@broad.mit.edu', '') where spacekey like '%@broad.mit.edu';

update BANDANA          set BANDANACONTEXT = REPLACE(BANDANACONTEXT, '@broad.mit.edu', '') where BANDANACONTEXT like '%@broad.mit.edu';

update ATTACHMENTS      set CREATOR = REPLACE(CREATOR, '@broad.mit.edu', '') where CREATOR like '%@broad.mit.edu';
update CONTENT          set CREATOR = REPLACE(CREATOR, '@broad.mit.edu', '') where CREATOR like '%@broad.mit.edu';
update LINKS            set CREATOR = REPLACE(CREATOR, '@broad.mit.edu', '') where CREATOR like '%@broad.mit.edu';
update NOTIFICATIONS    set CREATOR = REPLACE(CREATOR, '@broad.mit.edu', '') where CREATOR like '%@broad.mit.edu';
update PAGETEMPLATES    set CREATOR = REPLACE(CREATOR, '@broad.mit.edu', '') where CREATOR like '%@broad.mit.edu';
update SPACES           set CREATOR = REPLACE(CREATOR, '@broad.mit.edu', '') where CREATOR like '%@broad.mit.edu';
update EXTRNLNKS        set CREATOR = REPLACE(CREATOR, '@broad.mit.edu', '') where CREATOR like '%@broad.mit.edu';
update SPACEPERMISSIONS set CREATOR = REPLACE(CREATOR, '@broad.mit.edu', '') where CREATOR like '%@broad.mit.edu';
update CONTENTLOCK      set CREATOR = REPLACE(CREATOR, '@broad.mit.edu', '') where CREATOR like '%@broad.mit.edu';
update TRACKBACKLINKS   set CREATOR = REPLACE(CREATOR, '@broad.mit.edu', '') where CREATOR like '%@broad.mit.edu';

update ATTACHMENTS      set lastmodifier = REPLACE(lastmodifier, '@broad.mit.edu', '') where lastmodifier like '%@broad.mit.edu';
update CONTENT          set lastmodifier = REPLACE(lastmodifier, '@broad.mit.edu', '') where lastmodifier like '%@broad.mit.edu';
update EXTRNLNKS        set lastmodifier = REPLACE(lastmodifier, '@broad.mit.edu', '') where lastmodifier like '%@broad.mit.edu';
update LINKS            set lastmodifier = REPLACE(lastmodifier, '@broad.mit.edu', '') where lastmodifier like '%@broad.mit.edu';
update NOTIFICATIONS    set lastmodifier = REPLACE(lastmodifier, '@broad.mit.edu', '') where lastmodifier like '%@broad.mit.edu';
update PAGETEMPLATES    set lastmodifier = REPLACE(lastmodifier, '@broad.mit.edu', '') where lastmodifier like '%@broad.mit.edu';
update SPACES           set lastmodifier = REPLACE(lastmodifier, '@broad.mit.edu', '') where lastmodifier like '%@broad.mit.edu';
update SPACEPERMISSIONS set lastmodifier = REPLACE(lastmodifier, '@broad.mit.edu', '') where lastmodifier like '%@broad.mit.edu';
update CONTENTLOCK      set lastmodifier = REPLACE(lastmodifier, '@broad.mit.edu', '') where lastmodifier like '%@broad.mit.edu';
update TRACKBACKLINKS   set lastmodifier = REPLACE(lastmodifier, '@broad.mit.edu', '') where lastmodifier like '%@broad.mit.edu';

update os_user          set USERNAME = REPLACE(USERNAME, '@broad.mit.edu', '') where USERNAME like '%@broad.mit.edu';

update users            set name = REPLACE(name, '@broad.mit.edu', '') where name like '%@broad.mit.edu';



update CONTENT          set USERNAME = REPLACE(USERNAME, '@broad.harvard.edu', '') where USERNAME like '%@broad.harvard.edu';

update LABEL            set OWNER = REPLACE(OWNER, '@broad.harvard.edu', '') where OWNER like '%@broad.harvard.edu';
update CONTENT_LABEL    set OWNER = REPLACE(OWNER, '@broad.harvard.edu', '') where OWNER like '%@broad.harvard.edu';

update SPACEPERMISSIONS set PERMUSERNAME = REPLACE(PERMUSERNAME, '@broad.harvard.edu', '') where PERMUSERNAME like '%@broad.harvard.edu';

update SPACES           set spacekey = REPLACE(spacekey, '@broad.harvard.edu', '') where spacekey like '%@broad.harvard.edu';
update CONTENT_LABEL    set spacekey = REPLACE(spacekey, '@broad.harvard.edu', '') where spacekey like '%@broad.harvard.edu';

update BANDANA          set BANDANACONTEXT = REPLACE(BANDANACONTEXT, '@broad.harvard.edu', '') where BANDANACONTEXT like '%@broad.harvard.edu';

update ATTACHMENTS      set CREATOR = REPLACE(CREATOR, '@broad.harvard.edu', '') where CREATOR like '%@broad.harvard.edu';
update CONTENT          set CREATOR = REPLACE(CREATOR, '@broad.harvard.edu', '') where CREATOR like '%@broad.harvard.edu';
update LINKS            set CREATOR = REPLACE(CREATOR, '@broad.harvard.edu', '') where CREATOR like '%@broad.harvard.edu';
update NOTIFICATIONS    set CREATOR = REPLACE(CREATOR, '@broad.harvard.edu', '') where CREATOR like '%@broad.harvard.edu';
update PAGETEMPLATES    set CREATOR = REPLACE(CREATOR, '@broad.harvard.edu', '') where CREATOR like '%@broad.harvard.edu';
update SPACES           set CREATOR = REPLACE(CREATOR, '@broad.harvard.edu', '') where CREATOR like '%@broad.harvard.edu';
update EXTRNLNKS        set CREATOR = REPLACE(CREATOR, '@broad.harvard.edu', '') where CREATOR like '%@broad.harvard.edu';
update SPACEPERMISSIONS set CREATOR = REPLACE(CREATOR, '@broad.harvard.edu', '') where CREATOR like '%@broad.harvard.edu';
update CONTENTLOCK      set CREATOR = REPLACE(CREATOR, '@broad.harvard.edu', '') where CREATOR like '%@broad.harvard.edu';
update TRACKBACKLINKS   set CREATOR = REPLACE(CREATOR, '@broad.harvard.edu', '') where CREATOR like '%@broad.harvard.edu';

update ATTACHMENTS      set lastmodifier = REPLACE(lastmodifier, '@broad.harvard.edu', '') where lastmodifier like '%@broad.harvard.edu';
update CONTENT          set lastmodifier = REPLACE(lastmodifier, '@broad.harvard.edu', '') where lastmodifier like '%@broad.harvard.edu';
update EXTRNLNKS        set lastmodifier = REPLACE(lastmodifier, '@broad.harvard.edu', '') where lastmodifier like '%@broad.harvard.edu';
update LINKS            set lastmodifier = REPLACE(lastmodifier, '@broad.harvard.edu', '') where lastmodifier like '%@broad.harvard.edu';
update NOTIFICATIONS    set lastmodifier = REPLACE(lastmodifier, '@broad.harvard.edu', '') where lastmodifier like '%@broad.harvard.edu';
update PAGETEMPLATES    set lastmodifier = REPLACE(lastmodifier, '@broad.harvard.edu', '') where lastmodifier like '%@broad.harvard.edu';
update SPACES           set lastmodifier = REPLACE(lastmodifier, '@broad.harvard.edu', '') where lastmodifier like '%@broad.harvard.edu';
update SPACEPERMISSIONS set lastmodifier = REPLACE(lastmodifier, '@broad.harvard.edu', '') where lastmodifier like '%@broad.harvard.edu';
update CONTENTLOCK      set lastmodifier = REPLACE(lastmodifier, '@broad.harvard.edu', '') where lastmodifier like '%@broad.harvard.edu';
update TRACKBACKLINKS   set lastmodifier = REPLACE(lastmodifier, '@broad.harvard.edu', '') where lastmodifier like '%@broad.harvard.edu';

update os_user          set USERNAME = REPLACE(USERNAME, '@broad.harvard.edu', '') where USERNAME like '%@broad.harvard.edu';

update users            set name = REPLACE(name, '@broad.harvard.edu', '') where name like '%@broad.harvard.edu';
