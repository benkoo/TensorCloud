<?php

/* @Live/index.twig */
class __TwigTemplate_515b2b2a5d6868e591b1efe0ac649500c090a8408b38b82e0b38df2c812f76f5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<script type=\"text/javascript\" charset=\"utf-8\">
    \$(document).ready(function () {
        var segment = broadcast.getValueFromHash('segment');
        if (!segment) {
            segment = broadcast.getValueFromUrl('segment');
        }

        \$('#visitsLive').liveWidget({
            interval: ";
        // line 9
        echo \Piwik\piwik_escape_filter($this->env, ($context["liveRefreshAfterMs"] ?? $this->getContext($context, "liveRefreshAfterMs")), "html", null, true);
        echo ",
            onUpdate: function () {
                //updates the numbers of total visits in startbox
                var ajaxRequest = new ajaxHelper();
                ajaxRequest.setFormat('html');
                ajaxRequest.addParams({
                    module: 'Live',
                    action: 'ajaxTotalVisitors',
                    segment: segment
                }, 'GET');
                ajaxRequest.setCallback(function (r) {
                    \$(\"#visitsTotal\").html(r);
                });
                ajaxRequest.send(false);
            },
            maxRows: 10,
            fadeInSpeed: 600,
            dataUrlParams: {
                module: 'Live',
                action: 'getLastVisitsStart',
                segment: segment
            }
        });
    });
</script>

";
        // line 35
        $this->loadTemplate("@Live/_totalVisitors.twig", "@Live/index.twig", 35)->display($context);
        // line 36
        echo "
";
        // line 37
        echo ($context["visitors"] ?? $this->getContext($context, "visitors"));
        echo "

";
        // line 39
        ob_start();
        // line 40
        echo "<div class=\"visitsLiveFooter\">
    <a title=\"";
        // line 41
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Live_OnClickPause", call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Live_VisitorsInRealTime")))), "html", null, true);
        echo "\" href=\"javascript:void(0);\" onclick=\"onClickPause();\">
        <img id=\"pauseImage\" border=\"0\" src=\"plugins/Live/images/pause.png\" />
    </a>
    <a title=\"";
        // line 44
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Live_OnClickStart", call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Live_VisitorsInRealTime")))), "html", null, true);
        echo "\" href=\"javascript:void(0);\" onclick=\"onClickPlay();\">
        <img id=\"playImage\" style=\"display: none;\" border=\"0\" src=\"plugins/Live/images/play.png\" />
    </a>
    ";
        // line 47
        if ( !($context["disableLink"] ?? $this->getContext($context, "disableLink"))) {
            // line 48
            echo "        &nbsp;
        <a class=\"rightLink\" href=\"#\" onclick=\"this.href=broadcast.buildReportingUrl('category=General_Visitors&subcategory=Live_VisitorLog')\">";
            // line 49
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Live_LinkVisitorLog")), "html", null, true);
            echo "</a>
    ";
        }
        // line 51
        echo "</div>
";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    public function getTemplateName()
    {
        return "@Live/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  95 => 51,  90 => 49,  87 => 48,  85 => 47,  79 => 44,  73 => 41,  70 => 40,  68 => 39,  63 => 37,  60 => 36,  58 => 35,  29 => 9,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<script type=\"text/javascript\" charset=\"utf-8\">
    \$(document).ready(function () {
        var segment = broadcast.getValueFromHash('segment');
        if (!segment) {
            segment = broadcast.getValueFromUrl('segment');
        }

        \$('#visitsLive').liveWidget({
            interval: {{ liveRefreshAfterMs }},
            onUpdate: function () {
                //updates the numbers of total visits in startbox
                var ajaxRequest = new ajaxHelper();
                ajaxRequest.setFormat('html');
                ajaxRequest.addParams({
                    module: 'Live',
                    action: 'ajaxTotalVisitors',
                    segment: segment
                }, 'GET');
                ajaxRequest.setCallback(function (r) {
                    \$(\"#visitsTotal\").html(r);
                });
                ajaxRequest.send(false);
            },
            maxRows: 10,
            fadeInSpeed: 600,
            dataUrlParams: {
                module: 'Live',
                action: 'getLastVisitsStart',
                segment: segment
            }
        });
    });
</script>

{% include \"@Live/_totalVisitors.twig\" %}

{{ visitors|raw }}

{% spaceless %}
<div class=\"visitsLiveFooter\">
    <a title=\"{{ 'Live_OnClickPause'|translate('Live_VisitorsInRealTime'|translate) }}\" href=\"javascript:void(0);\" onclick=\"onClickPause();\">
        <img id=\"pauseImage\" border=\"0\" src=\"plugins/Live/images/pause.png\" />
    </a>
    <a title=\"{{ 'Live_OnClickStart'|translate('Live_VisitorsInRealTime'|translate) }}\" href=\"javascript:void(0);\" onclick=\"onClickPlay();\">
        <img id=\"playImage\" style=\"display: none;\" border=\"0\" src=\"plugins/Live/images/play.png\" />
    </a>
    {% if not disableLink %}
        &nbsp;
        <a class=\"rightLink\" href=\"#\" onclick=\"this.href=broadcast.buildReportingUrl('category=General_Visitors&subcategory=Live_VisitorLog')\">{{ 'Live_LinkVisitorLog'|translate }}</a>
    {% endif %}
</div>
{% endspaceless %}
", "@Live/index.twig", "/var/www/html/plugins/Live/templates/index.twig");
    }
}
