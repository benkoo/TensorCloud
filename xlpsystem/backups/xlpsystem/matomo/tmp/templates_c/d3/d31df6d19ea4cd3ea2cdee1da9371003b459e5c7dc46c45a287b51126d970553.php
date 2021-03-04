<?php

/* @Dashboard/_dashboardSettings.twig */
class __TwigTemplate_4c5b97e3d8a64901a1e4f7b62b444a25e10eb0acdbb6b5e9cc4e10baa6a18554 extends Twig_Template
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
        echo "<a class=\"title\" title=\"";
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_ManageDashboard")), "html_attr");
        echo "\" tabindex=\"4\"><span class=\"icon icon-arrow-bottom\"></span>";
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_Dashboard")), "html", null, true);
        echo " </a>
<div class=\"dropdown positionInViewport\">
    <ul class=\"submenu\">
        <li>
            <div class=\"addWidget\">";
        // line 5
        echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_AddAWidget")), "html", null, true);
        echo "</div>
            <ul class=\"widgetpreview-categorylist\"></ul>
        </li>
        ";
        // line 8
        if ((twig_length_filter($this->env, ($context["dashboardActions"] ?? $this->getContext($context, "dashboardActions"))) > 0)) {
            // line 9
            echo "            <li>
                <div class=\"manageDashboard\">";
            // line 10
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array("Dashboard_ManageDashboard")), "html", null, true);
            echo "</div>
                <ul>
                    ";
            // line 12
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["dashboardActions"] ?? $this->getContext($context, "dashboardActions")));
            foreach ($context['_seq'] as $context["action"] => $context["title"]) {
                // line 13
                echo "                        <li data-action=\"";
                echo \Piwik\piwik_escape_filter($this->env, $context["action"], "html", null, true);
                echo "\">";
                echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array($context["title"])), "html", null, true);
                echo "</li>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['action'], $context['title'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 15
            echo "                </ul>
            </li>
        ";
        }
        // line 18
        echo "        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["generalActions"] ?? $this->getContext($context, "generalActions")));
        foreach ($context['_seq'] as $context["action"] => $context["title"]) {
            // line 19
            echo "            <li class=\"generalAction\" data-action=\"";
            echo \Piwik\piwik_escape_filter($this->env, $context["action"], "html", null, true);
            echo "\">";
            echo \Piwik\piwik_escape_filter($this->env, call_user_func_array($this->env->getFilter('translate')->getCallable(), array($context["title"])), "html", null, true);
            echo "</li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['action'], $context['title'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        echo "    </ul>
    <ul class=\"widgetpreview-widgetlist\"></ul>
    <div class=\"widgetpreview-preview\"></div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@Dashboard/_dashboardSettings.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  81 => 21,  70 => 19,  65 => 18,  60 => 15,  49 => 13,  45 => 12,  40 => 10,  37 => 9,  35 => 8,  29 => 5,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<a class=\"title\" title=\"{{ 'Dashboard_ManageDashboard'|translate|e('html_attr') }}\" tabindex=\"4\"><span class=\"icon icon-arrow-bottom\"></span>{{ 'Dashboard_Dashboard'|translate }} </a>
<div class=\"dropdown positionInViewport\">
    <ul class=\"submenu\">
        <li>
            <div class=\"addWidget\">{{ 'Dashboard_AddAWidget'|translate }}</div>
            <ul class=\"widgetpreview-categorylist\"></ul>
        </li>
        {% if dashboardActions|length > 0 %}
            <li>
                <div class=\"manageDashboard\">{{ 'Dashboard_ManageDashboard'|translate }}</div>
                <ul>
                    {% for action, title in dashboardActions %}
                        <li data-action=\"{{ action }}\">{{ title|translate }}</li>
                    {% endfor %}
                </ul>
            </li>
        {% endif %}
        {% for action, title in generalActions %}
            <li class=\"generalAction\" data-action=\"{{ action }}\">{{ title|translate }}</li>
        {% endfor %}
    </ul>
    <ul class=\"widgetpreview-widgetlist\"></ul>
    <div class=\"widgetpreview-preview\"></div>
</div>
", "@Dashboard/_dashboardSettings.twig", "/var/www/html/plugins/Dashboard/templates/_dashboardSettings.twig");
    }
}
