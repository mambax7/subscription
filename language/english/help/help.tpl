<div id="help-template" class="outer">
    <{include file=$smarty.const._MI_SUBSCRIPTION_HELP_HEADER}>

    <h4 class="odd">DESCRIPTION</h4> <br>

    <p class="even">The subscription module allows you to create and manage subscriptions for your XOOPS
        content. When a user "purchases" a subscription, he or she is added to the
        XOOPS security group that the subscription's type is assigned.<br> <br>

        A subscription has a subsciption type and a subscription interval. A
        subscription type can have a parent Subscription type. This is useful to
        create a hierarchy of subscription types. Currently, child subscription types
        DO NOT inherit properties or behaviors from its parent. This will be a feature
        of a future release..<br> <br>
    </p>

    <h4 class="odd">INSTALL/UNINSTALL</h4>

    <p class="even">No special measures necessary, follow the standard installation process –
        extract the module folder into the ../modules directory. Install the
        module through Admin -> System Module -> Modules.<br> <br>
        Detailed instructions on installing modules are available in the
        <a href="https://xoops.gitbook.io/xoops-operations-guide/" target="_blank">XOOPS Operations Manual</a></p>


    <h4 class="odd">OPERATING INSTRUCTIONS</h4><br>

    1) Before you get started, it's useful to create the new groups that you will
    assign your subscription types (in step 2) to. Creating new groups is
    accomplished from the Groups Admin section in the System Panel.<br> <br>

    2) The first step in using the Subscription Module is to create the subscription
    intervals. Monthly and Yearly intervals are created by default. You must
    assign an interval type to each interval. For instance, if you wanted a
    monthly interval to renew every 30 days, you would choose the interval type
    'Day' and the interval amount of '30'. By default, the Monthly interval is set
    up to renew every month (type=Month, amount=1).<br> <br>

    3) Create or edit subscription types. Basic and Premium subscription types are
    created during installation. These subscription types are used to relate a set
    of subscriptions with the security groups the users will be assigned to if they
    purchased a subscription. If you have not created new security groups to
    support the different access levels to your XOOPS site, you should do this
    before continuing.<br> <br>

    4) Create subscriptions with one of the types and intervals created in the
    previous steps. When a user purchases one of these subscriptions, he or she
    will be automatically added to the security group assigned to the subscription
    type for that subscription.<br> <br>

    <h4 class="odd">TUTORIAL</h4> <br>

    <p class="even">
        Tutorial has been started, but we might need your help! Please check out the status of the tutorial <a href="https://xoops.gitbook.io/subscription-tutorial/" target="_blank">here </a>.
        <br><br>To contribute to this Tutorial, <a href="https://github.com/XoopsDocs/subscription-tutorial/" target="_blank">please fork it on GitHub</a>.
        <br> This document describes our <a href="https://xoops.gitbook.io/xoops-documentation-process/details/" target="_blank">Documentation Process</a> and it will help you to understand how to contribute.
        <br><br>
        There are more XOOPS Tutorials, so check them out in our <a href="https://www.gitbook.com/@xoops/" target="_blank">XOOPS Tutorial Repository on GitBook</a>.
    </p>


    <h4 class="odd">TRANSLATIONS</h4> <br>
    <p class="even">
        Translations are on <a href="https://www.transifex.com/xoops/" target="_blank">Transifex</a> and in our <a href="https://github.com/XoopsLanguages/" target="_blank">XOOPS Languages Repository on GitHub</a>.</p>

    <h4 class="odd">SUPPORT</h4> <br>
    <p class="even">
        If you have questions about this module and need help, you can visit our <a href="https://xoops.org/modules/newbb/viewforum.php?forum=28/" target="_blank">Support Forums on XOOPS Website</a></p>

    <h4 class="odd">DEVELOPMENT</h4> <br>
    <p class="even">
        This module is Open Source and we would love your help in making it better! You can fork this module on <a href="https://github.com/XoopsModulesArchive/subscription" target="_blank">GitHub</a><br><br>
        But there is more happening on GitHub:<br><br>
        - <a href="https://github.com/xoops" target="_blank">XOOPS Core</a> <br>
        - <a href="https://github.com/XoopsModules25x" target="_blank">XOOPS Modules</a><br>
        - <a href="https://github.com/XoopsThemes" target="_blank">XOOPS Themes</a><br><br>
        Go check it out, and <strong>GET INVOLVED</strong>

    </p>

</div>
