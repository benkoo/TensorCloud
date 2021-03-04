<?php

/* @SitesManager/siteWithoutData.twig */
class __TwigTemplate_c7b21f3c616586ae6b3e987cc6b7effdd1d83068f30f3e12550efcd340211512 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("dashboard.twig", "@SitesManager/siteWithoutData.twig", 1);
        $this->blocks = array(
            'notification' => array($this, 'block_notification'),
            'topcontrols' => array($this, 'block_topcontrols'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "dashboard.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_notification($context, array $blocks = array())
    {
    }

    // line 5
    public function block_topcontrols($context, array $blocks = array())
    {
        // line 6
        echo "    ";
        $this->loadTemplate("@CoreHome/_siteSelectHeader.twig", "@SitesManager/siteWithoutData.twig", 6)->display($context);
    }

    // line 9
    public function block_content($context, array $blocks = array())
    {
        // line 10
        echo "
    <script type=\"text/javascript\" charset=\"utf-8\">
        \$(document).ready(function () {
            \$('<div />').insertAfter('.site-without-data').liveWidget({
                interval: 1000,
                onUpdate: function () {
                    // reload page as soon as a visit was detected
                    broadcast.propagateNewPage('date=today');
                },
                dataUrlParams: {
                    module: 'Live',
                    action: 'getLastVisitsStart'
                }
            });
        });
    </script>

    <div class=\"site-without-data\">

        <h2>";
        // line 29
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_SiteWithoutDataTitle")), "html", null, true);
        echo "</h2>

        <p>
            ";
        // line 32
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_SiteWithoutDataDescription")), "html", null, true);
        echo "
            ";
        // line 33
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_SiteWithoutDataSetupTracking", (("<a href=\"" . call_user_func_array($this->env->getFunction('linkTo')->getCallable(), array(array("module" => "CoreAdminHome", "action" => "trackingCodeGenerator")))) . "\">"), "</a>"));
        // line 36
        echo "
        </p>

        <p>
            ";
        // line 40
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_SiteWithoutDataMessageDisappears")), "html", null, true);
        echo "
            ";
        // line 41
        echo call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_SiteWithoutDataSetupGoals", (("<a href=\"" . call_user_func_array($this->env->getFunction('linkTo')->getCallable(), array(array("module" => "Goals", "action" => "manage")))) . "\">"), "</a>", "<a href=\"https://matomo.org/features/\" rel=\"noreferrer\" target=\"_blank\">", "</a>", "<a href=\"https://matomo.org/docs/\" rel=\"noreferrer\" target=\"_blank\">", "</a>", "<a href=\"https://matomo.org/faq/\" rel=\"noreferrer\" target=\"_blank\">", "</a>"));
        // line 47
        echo "

            <br />
            <br />
            <a href=\"";
        // line 51
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFunction('linkTo')->getCallable(), array(array("module" => "SitesManager", "action" => "ignoreNoDataMessage"))), "html", null, true);
        echo "\"
               class=\"btn ignoreSitesWithoutData\">";
        // line 52
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("SitesManager_SiteWithoutDataIgnoreMessage")), "html", null, true);
        echo "</a>
        </p>

        ";
        // line 55
        echo ($context["trackingHelp"] ?? $this->getContext($context, "trackingHelp"));
        echo "

    </div>

";
    }

    public function getTemplateName()
    {
        return "@SitesManager/siteWithoutData.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  107 => 55,  101 => 52,  97 => 51,  91 => 47,  89 => 41,  85 => 40,  79 => 36,  77 => 33,  73 => 32,  67 => 29,  46 => 10,  43 => 9,  38 => 6,  35 => 5,  30 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"dashboard.twig\" %}

{% block notification %}{% endblock %}

{% block topcontrols %}
    {% include \"@CoreHome/_siteSelectHeader.twig\" %}
{% endblock %}

{% block content %}

    <script type=\"text/javascript\" charset=\"utf-8\">
        \$(document).ready(function () {
            \$('<div />').insertAfter('.site-without-data').liveWidget({
                interval: 1000,
                onUpdate: function () {
                    // reload page as soon as a visit was detected
                    broadcast.propagateNewPage('date=today');
                },
                dataUrlParams: {
                    module: 'Live',
                    action: 'getLastVisitsStart'
                }
            });
        });
    </script>

    <div class=\"site-without-data\">

        <h2>{{ 'SitesManager_SiteWithoutDataTitle'|translate }}</h2>

        <p>
            {{ 'SitesManager_SiteWithoutDataDescription'|translate }}
            {{ 'SitesManager_SiteWithoutDataSetupTracking'|translate('<a href=\"' ~ linkTo({
                'module': 'CoreAdminHome',
                'action': 'trackingCodeGenerator',
            }) ~ '\">', \"</a>\")|raw }}
        </p>

        <p>
            {{ 'SitesManager_SiteWithoutDataMessageDisappears'|translate }}
            {{ 'SitesManager_SiteWithoutDataSetupGoals'|translate('<a href=\"' ~ linkTo({
                'module': 'Goals',
                'action': 'manage',
            }) ~ '\">', \"</a>\",
            '<a href=\"https://matomo.org/features/\" rel=\"noreferrer\" target=\"_blank\">', \"</a>\",
            '<a href=\"https://matomo.org/docs/\" rel=\"noreferrer\" target=\"_blank\">', \"</a>\",
            '<a href=\"https://matomo.org/faq/\" rel=\"noreferrer\" target=\"_blank\">', \"</a>\")|raw }}

            <br />
            <br />
            <a href=\"{{ linkTo({module: 'SitesManager', action: 'ignoreNoDataMessage'}) }}\"
               class=\"btn ignoreSitesWithoutData\">{{ 'SitesManager_SiteWithoutDataIgnoreMessage'|translate }}</a>
        </p>

        {{ trackingHelp|raw }}

    </div>

{% endblock %}
", "@SitesManager/siteWithoutData.twig", "/var/www/html/plugins/SitesManager/templates/siteWithoutData.twig");
    }
}
