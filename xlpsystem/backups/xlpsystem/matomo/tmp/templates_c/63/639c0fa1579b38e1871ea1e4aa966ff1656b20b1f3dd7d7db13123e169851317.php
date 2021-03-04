<?php

/* @Morpheus/layout.twig */
class __TwigTemplate_663860c577922b83d1d17ed15fbb4ed231ed98183dd0f3bff7f8de3103a1830b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'pageTitle' => array($this, 'block_pageTitle'),
            'pageDescription' => array($this, 'block_pageDescription'),
            'meta' => array($this, 'block_meta'),
            'body' => array($this, 'block_body'),
            'root' => array($this, 'block_root'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html id=\"ng-app\" ";
        // line 2
        if (array_key_exists("language", $context)) {
            echo "lang=\"";
            echo \Piwik\piwik_escape_filter($this->env, ($context["language"] ?? $this->getContext($context, "language")), "html", null, true);
            echo "\"";
        }
        echo " ng-app=\"piwikApp\">
    <head>
        ";
        // line 4
        $this->displayBlock('head', $context, $blocks);
        // line 31
        echo "    </head>
    <body id=\"";
        // line 32
        echo \Piwik\piwik_escape_filter($this->env, ((array_key_exists("bodyId", $context)) ? (_twig_default_filter(($context["bodyId"] ?? $this->getContext($context, "bodyId")), "")) : ("")), "html", null, true);
        echo "\" ng-app=\"app\" class=\"";
        echo \Piwik\piwik_escape_filter($this->env, ((array_key_exists("bodyClass", $context)) ? (_twig_default_filter(($context["bodyClass"] ?? $this->getContext($context, "bodyClass")), "")) : ("")), "html", null, true);
        echo "\">

    ";
        // line 34
        $this->displayBlock('body', $context, $blocks);
        // line 49
        echo "
        ";
        // line 50
        $this->loadTemplate("@CoreHome/_adblockDetect.twig", "@Morpheus/layout.twig", 50)->display($context);
        // line 51
        echo "    </body>
</html>
";
    }

    // line 4
    public function block_head($context, array $blocks = array())
    {
        // line 5
        echo "            <meta charset=\"utf-8\">
            <title>";
        // line 7
        $this->displayBlock('pageTitle', $context, $blocks);
        // line 12
        echo "</title>
            <meta http-equiv=\"X-UA-Compatible\" content=\"IE=EDGE,chrome=1\"/>
            <meta name=\"viewport\" content=\"initial-scale=1.0\"/>
            <meta name=\"generator\" content=\"Matomo - free/libre analytics platform\"/>
            <meta name=\"description\" content=\"";
        // line 16
        $this->displayBlock('pageDescription', $context, $blocks);
        echo "\"/>
            <meta name=\"apple-itunes-app\" content=\"app-id=737216887\" />
            ";
        // line 18
        $this->displayBlock('meta', $context, $blocks);
        // line 21
        echo "
            ";
        // line 22
        $this->loadTemplate("@CoreHome/_favicon.twig", "@Morpheus/layout.twig", 22)->display($context);
        // line 23
        echo "            ";
        $this->loadTemplate("@CoreHome/_applePinnedTabIcon.twig", "@Morpheus/layout.twig", 23)->display($context);
        // line 24
        echo "            <meta name=\"theme-color\" content=\"#37474f\">
            ";
        // line 25
        $this->loadTemplate("_jsGlobalVariables.twig", "@Morpheus/layout.twig", 25)->display($context);
        // line 26
        echo "            ";
        $this->loadTemplate("_jsCssIncludes.twig", "@Morpheus/layout.twig", 26)->display($context);
        // line 28
        if ( !($context["isCustomLogo"] ?? $this->getContext($context, "isCustomLogo"))) {
            echo "<link rel=\"manifest\" href=\"plugins/CoreHome/javascripts/manifest.json\">";
        }
        // line 29
        echo "
        ";
    }

    // line 7
    public function block_pageTitle($context, array $blocks = array())
    {
        // line 8
        if (array_key_exists("title", $context)) {
            echo \Piwik\piwik_escape_filter($this->env, ($context["title"] ?? $this->getContext($context, "title")), "html", null, true);
            echo " - ";
        }
        // line 9
        if (array_key_exists("categoryTitle", $context)) {
            echo \Piwik\piwik_escape_filter($this->env, ($context["categoryTitle"] ?? $this->getContext($context, "categoryTitle")), "html", null, true);
            echo " - ";
        }
        // line 10
        echo "                    Matomo";
    }

    // line 16
    public function block_pageDescription($context, array $blocks = array())
    {
    }

    // line 18
    public function block_meta($context, array $blocks = array())
    {
        // line 19
        echo "                <meta name=\"robots\" content=\"noindex,nofollow\">
            ";
    }

    // line 34
    public function block_body($context, array $blocks = array())
    {
        // line 35
        echo "
        ";
        // line 36
        $this->loadTemplate("_iframeBuster.twig", "@Morpheus/layout.twig", 36)->display($context);
        // line 37
        echo "        ";
        $this->loadTemplate("@CoreHome/_javaScriptDisabled.twig", "@Morpheus/layout.twig", 37)->display($context);
        // line 38
        echo "
        <div id=\"root\">
            ";
        // line 40
        $this->displayBlock('root', $context, $blocks);
        // line 42
        echo "        </div>

        <div piwik-popover-handler></div>

        ";
        // line 46
        $this->loadTemplate("@CoreHome/_shortcuts.twig", "@Morpheus/layout.twig", 46)->display($context);
        // line 47
        echo "
    ";
    }

    // line 40
    public function block_root($context, array $blocks = array())
    {
        // line 41
        echo "            ";
    }

    public function getTemplateName()
    {
        return "@Morpheus/layout.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  171 => 41,  168 => 40,  163 => 47,  161 => 46,  155 => 42,  153 => 40,  149 => 38,  146 => 37,  144 => 36,  141 => 35,  138 => 34,  133 => 19,  130 => 18,  125 => 16,  121 => 10,  116 => 9,  111 => 8,  108 => 7,  103 => 29,  99 => 28,  96 => 26,  94 => 25,  91 => 24,  88 => 23,  86 => 22,  83 => 21,  81 => 18,  76 => 16,  70 => 12,  68 => 7,  65 => 5,  62 => 4,  56 => 51,  54 => 50,  51 => 49,  49 => 34,  42 => 32,  39 => 31,  37 => 4,  28 => 2,  25 => 1,);
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
<html id=\"ng-app\" {% if language is defined %}lang=\"{{ language }}\"{% endif %} ng-app=\"piwikApp\">
    <head>
        {% block head %}
            <meta charset=\"utf-8\">
            <title>
                {%- block pageTitle -%}
                    {%- if title is defined %}{{ title }} - {% endif %}
                    {%- if categoryTitle is defined %}{{ categoryTitle }} - {% endif %}
                    Matomo
                {%- endblock -%}
            </title>
            <meta http-equiv=\"X-UA-Compatible\" content=\"IE=EDGE,chrome=1\"/>
            <meta name=\"viewport\" content=\"initial-scale=1.0\"/>
            <meta name=\"generator\" content=\"Matomo - free/libre analytics platform\"/>
            <meta name=\"description\" content=\"{% block pageDescription %}{% endblock %}\"/>
            <meta name=\"apple-itunes-app\" content=\"app-id=737216887\" />
            {% block meta %}
                <meta name=\"robots\" content=\"noindex,nofollow\">
            {% endblock %}

            {% include \"@CoreHome/_favicon.twig\" %}
            {% include \"@CoreHome/_applePinnedTabIcon.twig\" %}
            <meta name=\"theme-color\" content=\"#37474f\">
            {% include \"_jsGlobalVariables.twig\" %}
            {% include \"_jsCssIncludes.twig\" %}

            {%- if not isCustomLogo %}<link rel=\"manifest\" href=\"plugins/CoreHome/javascripts/manifest.json\">{% endif %}

        {% endblock %}
    </head>
    <body id=\"{{ bodyId|default('') }}\" ng-app=\"app\" class=\"{{ bodyClass|default('') }}\">

    {% block body %}

        {% include \"_iframeBuster.twig\" %}
        {% include \"@CoreHome/_javaScriptDisabled.twig\" %}

        <div id=\"root\">
            {% block root %}
            {% endblock %}
        </div>

        <div piwik-popover-handler></div>

        {% include \"@CoreHome/_shortcuts.twig\" %}

    {% endblock %}

        {% include \"@CoreHome/_adblockDetect.twig\" %}
    </body>
</html>
", "@Morpheus/layout.twig", "/var/www/html/plugins/Morpheus/templates/layout.twig");
    }
}
