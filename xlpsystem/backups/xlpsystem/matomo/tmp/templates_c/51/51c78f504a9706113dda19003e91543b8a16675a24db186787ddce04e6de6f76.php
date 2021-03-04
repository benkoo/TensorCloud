<?php

/* @Installation/layout.twig */
class __TwigTemplate_0b5496c5aa49adb77369b5e9d169cf121e736ffd16f9c2fe5d037dae36a0be69 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html id=\"ng-app\" ng-app=\"piwikApp\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"robots\" content=\"noindex,nofollow\">
    <title>Matomo ";
        // line 6
        echo \Piwik\piwik_escape_filter($this->env, ($context["piwikVersion"] ?? $this->getContext($context, "piwikVersion")), "html", null, true);
        echo " &rsaquo; ";
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_Installation")), "html", null, true);
        echo "</title>

    <link rel=\"stylesheet\" type=\"text/css\" href=\"index.php?module=Installation&action=getInstallationCss\"/>
    <script type=\"text/javascript\" src=\"index.php?module=Installation&action=getInstallationJs\"></script>

    <link rel=\"shortcut icon\" href=\"plugins/CoreHome/images/favicon.png\"/>
</head>
<body ng-app=\"app\" id=\"installation\">
<div class=\"container\">

    <div class=\"header\">
        <div class=\"logo\">
            <img title=\"Matomo ";
        // line 18
        echo \Piwik\piwik_escape_filter($this->env, ($context["piwikVersion"] ?? $this->getContext($context, "piwikVersion")), "html", null, true);
        echo " - ";
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_OpenSourceWebAnalytics")), "html_attr");
        echo "\" src=\"plugins/Morpheus/images/logo.png\"/>
            <p>";
        // line 19
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_OpenSourceWebAnalytics")), "html", null, true);
        echo "</p>
        </div>
        <div class=\"language-selector\">
            ";
        // line 22
        echo call_user_func_array($this->env->getFunction('postEvent')->getCallable(), array("Template.topBar"));
        echo "
        </div>

        <div class=\"installation-progress\">
            <h4>
                ";
        // line 27
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Installation_InstallationStatus")), "html", null, true);
        echo "
                <small>";
        // line 28
        echo \Piwik\piwik_escape_filter($this->env, ($context["percentDone"] ?? $this->getContext($context, "percentDone")), "html", null, true);
        echo "%</small>
            </h4>
            <div class=\"progress\">
                <div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"60\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: ";
        // line 31
        echo \Piwik\piwik_escape_filter($this->env, ($context["percentDone"] ?? $this->getContext($context, "percentDone")), "html", null, true);
        echo "%;\"></div>
            </div>
        </div>

        <div class=\"clearfix\"></div>
    </div>

    <div class=\"row\">
        <div class=\"col s3\">
            <ul class=\"list-group\">
                ";
        // line 41
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["allStepsTitle"] ?? $this->getContext($context, "allStepsTitle")));
        foreach ($context['_seq'] as $context["stepId"] => $context["stepName"]) {
            // line 42
            echo "                    ";
            if ((($context["currentStepId"] ?? $this->getContext($context, "currentStepId")) > $context["stepId"])) {
                // line 43
                echo "                        ";
                $context["stepClass"] = "disabled";
                // line 44
                echo "                    ";
            } elseif ((($context["currentStepId"] ?? $this->getContext($context, "currentStepId")) == $context["stepId"])) {
                // line 45
                echo "                        ";
                $context["stepClass"] = "active";
                // line 46
                echo "                    ";
            } else {
                // line 47
                echo "                        ";
                $context["stepClass"] = "";
                // line 48
                echo "                    ";
            }
            // line 49
            echo "                    <li class=\"list-group-item ";
            echo \Piwik\piwik_escape_filter($this->env, ($context["stepClass"] ?? $this->getContext($context, "stepClass")), "html", null, true);
            echo "\">";
            echo \Piwik\piwik_escape_filter($this->env, ($context["stepId"] + 1), "html", null, true);
            echo ". ";
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array($context["stepName"])), "html", null, true);
            echo "</li>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['stepId'], $context['stepName'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 51
        echo "            </ul>
        </div>
        <div class=\"col s9 content\">
            ";
        // line 54
        ob_start();
        // line 55
        echo "                <p class=\"next-step\">
                    <a class=\"btn\" href=\"";
        // line 56
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFunction('linkTo')->getCallable(), array(array("action" => ($context["nextModuleName"] ?? $this->getContext($context, "nextModuleName")), "token_auth" => null, "method" => null))), "html", null, true);
        echo "\">
                        ";
        // line 57
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("General_Next")), "html", null, true);
        echo " &raquo;</a>
                </p>
            ";
        $context["nextButton"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 60
        echo "            ";
        if ((array_key_exists("showNextStepAtTop", $context) && ($context["showNextStepAtTop"] ?? $this->getContext($context, "showNextStepAtTop")))) {
            // line 61
            echo "                ";
            echo \Piwik\piwik_escape_filter($this->env, ($context["nextButton"] ?? $this->getContext($context, "nextButton")), "html", null, true);
            echo "
            ";
        }
        // line 63
        echo "
            ";
        // line 64
        $this->displayBlock('content', $context, $blocks);
        // line 65
        echo "
            ";
        // line 66
        if (($context["showNextStep"] ?? $this->getContext($context, "showNextStep"))) {
            // line 67
            echo "                ";
            echo \Piwik\piwik_escape_filter($this->env, ($context["nextButton"] ?? $this->getContext($context, "nextButton")), "html", null, true);
            echo "
            ";
        }
        // line 69
        echo "        </div>
    </div>

</div>

<div id=\"should-get-hidden\"
     style=\"color: red;margin-left: 16px;margin-bottom: 16px;font-weight:bold;font-size: 20px\">
    <p class=\"should-get-hidden-by-js\">
        ";
        // line 77
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_JsDidntLoad")), "html", null, true);
        echo "
    </p>
    <p class=\"should-get-hidden-by-css\">
        ";
        // line 80
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("CoreHome_CssDidntLoad")), "html", null, true);
        echo "
    </p>
</div>
";
        // line 83
        $this->loadTemplate("@CoreHome/_adblockDetect.twig", "@Installation/layout.twig", 83)->display($context);
        // line 84
        echo "</body>
</html>
";
    }

    // line 64
    public function block_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "@Installation/layout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  200 => 64,  194 => 84,  192 => 83,  186 => 80,  180 => 77,  170 => 69,  164 => 67,  162 => 66,  159 => 65,  157 => 64,  154 => 63,  148 => 61,  145 => 60,  139 => 57,  135 => 56,  132 => 55,  130 => 54,  125 => 51,  112 => 49,  109 => 48,  106 => 47,  103 => 46,  100 => 45,  97 => 44,  94 => 43,  91 => 42,  87 => 41,  74 => 31,  68 => 28,  64 => 27,  56 => 22,  50 => 19,  44 => 18,  27 => 6,  20 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html id=\"ng-app\" ng-app=\"piwikApp\">
<head>
    <meta charset=\"utf-8\">
    <meta name=\"robots\" content=\"noindex,nofollow\">
    <title>Matomo {{ piwikVersion }} &rsaquo; {{ 'Installation_Installation'|translate }}</title>

    <link rel=\"stylesheet\" type=\"text/css\" href=\"index.php?module=Installation&action=getInstallationCss\"/>
    <script type=\"text/javascript\" src=\"index.php?module=Installation&action=getInstallationJs\"></script>

    <link rel=\"shortcut icon\" href=\"plugins/CoreHome/images/favicon.png\"/>
</head>
<body ng-app=\"app\" id=\"installation\">
<div class=\"container\">

    <div class=\"header\">
        <div class=\"logo\">
            <img title=\"Matomo {{ piwikVersion }} - {{ 'General_OpenSourceWebAnalytics'|translate|escape('html_attr') }}\" src=\"plugins/Morpheus/images/logo.png\"/>
            <p>{{ 'General_OpenSourceWebAnalytics'|translate }}</p>
        </div>
        <div class=\"language-selector\">
            {{ postEvent('Template.topBar')|raw }}
        </div>

        <div class=\"installation-progress\">
            <h4>
                {{ 'Installation_InstallationStatus'|translate }}
                <small>{{ percentDone }}%</small>
            </h4>
            <div class=\"progress\">
                <div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"60\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: {{ percentDone }}%;\"></div>
            </div>
        </div>

        <div class=\"clearfix\"></div>
    </div>

    <div class=\"row\">
        <div class=\"col s3\">
            <ul class=\"list-group\">
                {% for stepId,stepName in allStepsTitle %}
                    {% if currentStepId > stepId %}
                        {% set stepClass = 'disabled' %}
                    {% elseif currentStepId == stepId %}
                        {% set stepClass = 'active' %}
                    {% else %}
                        {% set stepClass = '' %}
                    {% endif %}
                    <li class=\"list-group-item {{ stepClass }}\">{{ stepId + 1 }}. {{ stepName|translate }}</li>
                {% endfor %}
            </ul>
        </div>
        <div class=\"col s9 content\">
            {% set nextButton %}
                <p class=\"next-step\">
                    <a class=\"btn\" href=\"{{ linkTo({'action':nextModuleName, 'token_auth':null, 'method':null }) }}\">
                        {{ 'General_Next'|translate }} &raquo;</a>
                </p>
            {% endset %}
            {% if showNextStepAtTop is defined and showNextStepAtTop %}
                {{ nextButton }}
            {% endif %}

            {% block content %}{% endblock %}

            {% if showNextStep %}
                {{ nextButton }}
            {% endif %}
        </div>
    </div>

</div>

<div id=\"should-get-hidden\"
     style=\"color: red;margin-left: 16px;margin-bottom: 16px;font-weight:bold;font-size: 20px\">
    <p class=\"should-get-hidden-by-js\">
        {{ 'CoreHome_JsDidntLoad'|translate }}
    </p>
    <p class=\"should-get-hidden-by-css\">
        {{ 'CoreHome_CssDidntLoad'|translate }}
    </p>
</div>
{% include \"@CoreHome/_adblockDetect.twig\" %}
</body>
</html>
", "@Installation/layout.twig", "/var/www/html/plugins/Installation/templates/layout.twig");
    }
}
