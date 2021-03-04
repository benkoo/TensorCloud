<?php

/* @CoreVisualizations/_dataTableViz_sparklines.twig */
class __TwigTemplate_e6c636f14723988938952be074367596c528a2ffb34fd106ba292535b7c9ca78 extends Twig_Template
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
        $context["macros"] = $this->loadTemplate("@CoreVisualizations/macros.twig", "@CoreVisualizations/_dataTableViz_sparklines.twig", 1);
        // line 2
        echo "
";
        // line 3
        if ( !($context["isWidget"] ?? $this->getContext($context, "isWidget"))) {
            // line 4
            echo "    <div class=\"card\"><div class=\"card-content\">
";
        }
        // line 6
        echo "    ";
        if ( !twig_test_empty(($context["title"] ?? $this->getContext($context, "title")))) {
            echo "<h2 class=\"card-title\"
                                    ";
            // line 7
            if ( !twig_test_empty(($context["titleAttributes"] ?? $this->getContext($context, "titleAttributes")))) {
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(($context["titleAttributes"] ?? $this->getContext($context, "titleAttributes")));
                foreach ($context['_seq'] as $context["attribute"] => $context["value"]) {
                    echo \Piwik\piwik_escape_filter($this->env, $context["attribute"], "html", null, true);
                    echo "=\"";
                    echo \Piwik\piwik_escape_filter($this->env, $context["value"], "html", null, true);
                    echo "\"";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['attribute'], $context['value'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
            }
            // line 8
            echo "                                >";
            echo \Piwik\piwik_escape_filter($this->env, ($context["title"] ?? $this->getContext($context, "title")), "html", null, true);
            echo "</h2>";
        }
        // line 9
        echo "    ";
        if ( !($context["isWidget"] ?? $this->getContext($context, "isWidget"))) {
            // line 10
            echo "    <div class=\"row\">
        <div class=\"col m6\">
    ";
        }
        // line 13
        echo "
            ";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["sparklines"] ?? $this->getContext($context, "sparklines")));
        foreach ($context['_seq'] as $context["key"] => $context["sparkline"]) {
            // line 15
            echo "                ";
            if (($context["key"] % 2 == 0)) {
                // line 16
                echo "                    ";
                echo $context["macros"]->getsingleSparkline($context["sparkline"], ($context["allMetricsDocumentation"] ?? $this->getContext($context, "allMetricsDocumentation")), ($context["areSparklinesLinkable"] ?? $this->getContext($context, "areSparklinesLinkable")));
                echo "
                ";
            }
            // line 18
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['sparkline'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        echo "
    ";
        // line 20
        if ( !($context["isWidget"] ?? $this->getContext($context, "isWidget"))) {
            // line 21
            echo "            <br style=\"clear:left\"/>
        </div>
        <div class=\"col m6\">
    ";
        }
        // line 25
        echo "
            ";
        // line 26
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["sparklines"] ?? $this->getContext($context, "sparklines")));
        foreach ($context['_seq'] as $context["key"] => $context["sparkline"]) {
            // line 27
            echo "                ";
            if (($context["key"] % 2 == 1)) {
                // line 28
                echo "                    ";
                echo $context["macros"]->getsingleSparkline($context["sparkline"], ($context["allMetricsDocumentation"] ?? $this->getContext($context, "allMetricsDocumentation")), ($context["areSparklinesLinkable"] ?? $this->getContext($context, "areSparklinesLinkable")));
                echo "
                ";
            }
            // line 30
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['sparkline'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        echo "
            <br style=\"clear:left\"/>

    ";
        // line 34
        if ( !($context["isWidget"] ?? $this->getContext($context, "isWidget"))) {
            // line 35
            echo "        </div>
    </div>
    ";
        }
        // line 38
        echo "
    ";
        // line 39
        if (($context["areSparklinesLinkable"] ?? $this->getContext($context, "areSparklinesLinkable"))) {
            // line 40
            echo "        ";
            $this->loadTemplate("_sparklineFooter.twig", "@CoreVisualizations/_dataTableViz_sparklines.twig", 40)->display($context);
            // line 41
            echo "    ";
        }
        // line 42
        echo "
    ";
        // line 43
        if ( !twig_test_empty(($context["footerMessage"] ?? $this->getContext($context, "footerMessage")))) {
            // line 44
            echo "        <div class='datatableFooterMessage'>";
            echo ($context["footerMessage"] ?? $this->getContext($context, "footerMessage"));
            echo "</div>
    ";
        }
        // line 46
        if ( !($context["isWidget"] ?? $this->getContext($context, "isWidget"))) {
            // line 47
            echo "        </div></div>
";
        }
    }

    public function getTemplateName()
    {
        return "@CoreVisualizations/_dataTableViz_sparklines.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  153 => 47,  151 => 46,  145 => 44,  143 => 43,  140 => 42,  137 => 41,  134 => 40,  132 => 39,  129 => 38,  124 => 35,  122 => 34,  117 => 31,  111 => 30,  105 => 28,  102 => 27,  98 => 26,  95 => 25,  89 => 21,  87 => 20,  84 => 19,  78 => 18,  72 => 16,  69 => 15,  65 => 14,  62 => 13,  57 => 10,  54 => 9,  49 => 8,  35 => 7,  30 => 6,  26 => 4,  24 => 3,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% import '@CoreVisualizations/macros.twig' as macros %}

{% if not isWidget %}
    <div class=\"card\"><div class=\"card-content\">
{% endif %}
    {% if title is not empty %}<h2 class=\"card-title\"
                                    {% if titleAttributes is not empty %}{% for attribute, value in titleAttributes %}{{ attribute }}=\"{{ value }}\"{% endfor %}{% endif %}
                                >{{ title }}</h2>{% endif %}
    {% if not isWidget %}
    <div class=\"row\">
        <div class=\"col m6\">
    {% endif %}

            {% for key, sparkline in sparklines %}
                {% if key is even %}
                    {{ macros.singleSparkline(sparkline, allMetricsDocumentation, areSparklinesLinkable) }}
                {% endif %}
            {% endfor %}

    {% if not isWidget %}
            <br style=\"clear:left\"/>
        </div>
        <div class=\"col m6\">
    {% endif %}

            {% for key, sparkline in sparklines %}
                {% if key is odd %}
                    {{ macros.singleSparkline(sparkline, allMetricsDocumentation, areSparklinesLinkable) }}
                {% endif %}
            {% endfor %}

            <br style=\"clear:left\"/>

    {% if not isWidget %}
        </div>
    </div>
    {% endif %}

    {%  if areSparklinesLinkable %}
        {% include \"_sparklineFooter.twig\" %}
    {% endif %}

    {% if footerMessage is not empty %}
        <div class='datatableFooterMessage'>{{ footerMessage | raw }}</div>
    {% endif %}
{% if not isWidget %}
        </div></div>
{% endif %}", "@CoreVisualizations/_dataTableViz_sparklines.twig", "/var/www/html/plugins/CoreVisualizations/templates/_dataTableViz_sparklines.twig");
    }
}
