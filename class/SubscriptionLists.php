<?php namespace XoopsModules\Subscription;

if (!defined('SUB_LISTS_INCLUDED')) {
    define('SUB_LISTS_INCLUDED', 1);

    /**
     * Class SubscriptionLists
     */
    class SubscriptionLists
    {
        /**
         * @param $psid
         * @return array
         */
        public static function getSubscriptionTypeList($psid = null)
        {
            $db  = \XoopsDatabaseFactory::getDatabaseConnection();
            $sql = 'SELECT subtypeid, type FROM ' . $db->prefix('subscription_type');
            if ($psid !== null) {
                $sql .= " where psid = $psid";
            }
            $sql    .= ' order by type asc';
            $ret    = [];
            $result = $db->query($sql);
            $ret[0] = 'None';
            while (false !== ($row = $db->fetchArray($result))) {
                $ret[$row['subtypeid']] = $row['type'];
            }

            return $ret;
        }

        /**
         * @return array
         */
        public static function getSubscriptionIntervalList()
        {
            $db     = \XoopsDatabaseFactory::getDatabaseConnection();
            $sql    = 'SELECT subintervalid, name FROM ' . $db->prefix('subscription_interval') . ' ORDER BY orderbit ASC';
            $ret    = [];
            $result = $db->query($sql);
            while (false !== ($row = $db->fetchArray($result))) {
                $ret[$row['subintervalid']] = $row['name'];
            }

            return $ret;
        }

        /**
         * @return array
         */
        public static function getSubscriptionList()
        {
            $db     = \XoopsDatabaseFactory::getDatabaseConnection();
            $sql    = 'SELECT subid, name, type FROM ' . $db->prefix('subscription') . ',' . $db->prefix('subscription_type') . ' WHERE ' . $db->prefix('subscription') . '.subtypeid = ' . $db->prefix('subscription_type') . '.subtypeid' . ' ORDER BY orderbit ASC';
            $ret    = [];
            $result = $db->query($sql);
            while (false !== ($row = $db->fetchArray($result))) {
                $ret[$row['subid']] = ($row['name'] . ' ' . $row['type']);
            }

            return $ret;
        }

        /**
         * @return array
         */
        public static function getGatewayList()
        {
            global $xoopsModule;
            $ret    = [];
            $db     = \XoopsDatabaseFactory::getDatabaseConnection();
            $sql    = 'SELECT conf_id , conf_value FROM ' . $db->prefix('config') . " WHERE conf_name = 'gateway' AND conf_modid = " . $xoopsModule->getVar('mid');
            $result = $db->query($sql);
            list($conf_id, $current_value) = $db->fetchRow($result);
            if (empty($conf_id)) {
                return $ret;
            }

            $sql    = 'select confop_name, confop_value from ' . $db->prefix('configoption') . " where conf_id = $conf_id";
            $result = $db->query($sql);
            while (false !== (list($conf_name, $conf_value) = $db->fetchRow($result))) {
                $ret[$conf_name] = $conf_value;
            }

            return $ret;
        }
    } //end class def
}
