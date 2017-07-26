CREATE TABLE bxmorning_datelog (
  id       INT(10)    NOT NULL AUTO_INCREMENT,
  unixtime INT(10)    NOT NULL,
  status   TINYINT(1) NOT NULL,
  PRIMARY KEY (id)
) TYPE = MyISAM;

CREATE TABLE bxmorning_walkup (
  wid         INT(10)      NOT NULL AUTO_INCREMENT,
  id          INT(10)      NOT NULL DEFAULT '0',
  uid         MEDIUMINT(5) NOT NULL DEFAULT '0',
  walkup_time INT(10)      NOT NULL DEFAULT '0',
  message     VARCHAR(255),
  early_flag  TINYINT(1)   NOT NULL DEFAULT '0',
  PRIMARY KEY (wid)
) TYPE = MyISAM;

CREATE TABLE bxmorning_excuse (
  eid        INT(10)      NOT NULL AUTO_INCREMENT,
  delay_time INT(10)      NOT NULL DEFAULT '0',
  subject    VARCHAR(255) NOT NULL DEFAULT '',
  excuse     TEXT         NOT NULL DEFAULT '',
  PRIMARY KEY (eid)
) TYPE = MyISAM;

INSERT INTO bxmorning_excuse VALUES (1, 60, '�ż֤�����', '���⤷�⤷{uname}�Ǥ���\n�����ߤޤ����ż֤�����Ǥƾ����٤줽���Ǥ���\n���ͤù�����Ϳ�����쵤�ˡ�');
INSERT INTO bxmorning_excuse VALUES (2, 120, '�ܳФޤ���', '���⤷�⤷{uname}�Ǥ���\n�����á����ߤޤ���!!\n���ܳФޤ���������˻ȤäƤ����������ä�Ĥ����ä��ꡢ{��ž�⡼��,�ޥʡ��⡼��,�Ÿ�����}�ˤ����ޤ�̲�äƤ��ޤäơ���˷���Ƥ��ޤ��ޤ�����');
INSERT INTO bxmorning_excuse VALUES
  (3, 180, 'ž�����', '���⤷�⤷{uname}�Ǥ���\n�����ߤޤ���ī��{���̽�,�ȥ���,��ʹ����}�Ԥä��顢�ܤ�����{�д����Ũ��,������Τ��̤�,ɡ�Ӥο��Ӥ�}{����ˡ��,�֤�����������,�����פ���}������ƶä���{���ξ�,����,�ꤹ��,����}����ž��Ƥ��ޤ��ޤ�����\n�����Ф餯�������Ƥ����ߤ����ǡ�Ϣ���٤�ޤ�����');
INSERT INTO bxmorning_excuse VALUES (4, 240, '���ӤȤ�',
                                     '������ˤ��ϡ�\n�����ߤޤ���ī�����ȹԤ����Ȼפä���Ǥ��������ʡ�{�ޥ��������å�,Ű�����}�λ����ˤ����äˤʤäƤ��뾮�ͤ���{秾��,�С��󥢥��Ⱦɸ���}�ˤ�����ʤ���⡢��ΤȤ���ˤ�äƤ��ơ����ͤ������򸫤������Τ�������Ƥ���äƤ�����Ǥ��͡�\n���֤��䡢�������Ҥ������\n���äƸ��ä���Ǥ����ɡ������褤�ȡ�\n���ǡ��Ǥ�ʤ��Ǥ���͡�\n��������ǯ���餤���äȤ����äˤʤ�äѤʤ����ä��櫓�Ǥ����ġľ��ͤ���ξ��֤⿴�ۤ���������äȾ��ͤ������˹ԤäƤ�����Ǥ����������γʤǥ����ܡ��ɲ����Τ����ѤǤ��͡�\n������ǤϺ�����мҤ��ޤ���');
INSERT INTO bxmorning_excuse VALUES (5, 300, '�ե���', '��{uname}�Ǥ���\n�����Τ͡ġĤɤ��������ȤǤ�����\n���ܤ����줳�죵���֤��ٹ路�Ƥ��Ǥ��衣\n���ʤΤˤʤ��ï���ͤ򵯤����Ƥ���ʤ��Ǥ�����\n��Ư��������ޤ���');
INSERT INTO bxmorning_excuse VALUES (6, 360, '��²��������',
                                     '�����ߤޤ��󡢤���ä����Ѥʤ��ȤˤʤäƤ��ޤäơ�Ϣ���٤�ޤ�����\n���¤ϡġĺ�ī��{�����㡢���㡢�����졢���졢���㡢���ޡ����㡢����}��{��Ʀ,UML��,���ܥɥ��,ToDoɽ,�Ͷ��Υ������塼��}��{��,ɡ,����,��,��ƻ,�����ܡ��ɤη��}��{�ͤޤ餻��,���������,�ܥȥॢ�åפ���}�޻ष�ޤ��ơġ�\n���������Ȥꤢ������ҤˤϽмҤ��ޤ��ʻŻ��⤿�ޤäƤ뤷�ˡ�\n�������Ͼ����ġĤȤ������Ȥˤʤ�Ȼפ��ޤ���');
