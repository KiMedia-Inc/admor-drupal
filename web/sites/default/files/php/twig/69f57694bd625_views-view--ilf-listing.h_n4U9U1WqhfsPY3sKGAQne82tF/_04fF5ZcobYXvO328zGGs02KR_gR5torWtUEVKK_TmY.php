<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* @ilovemyfujitsu/views/views-view--ilf-listing.html.twig */
class __TwigTemplate_d75594ef8cd98242ee7e6fa38ff78477 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("ilovemyfujitsu/global"), "html", null, true);
        yield "

<section class=\"fujitsu-page-hero ilf-listing-hero\">
  <div class=\"container\">
    <p class=\"fujitsu-eyebrow\">";
        // line 5
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["kicker"] ?? null), "html", null, true);
        yield "</p>
    <h1>";
        // line 6
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["heading"] ?? null), "html", null, true);
        yield "</h1>
    <p>";
        // line 7
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["intro"] ?? null), "html", null, true);
        yield "</p>
  </div>
</section>

<section class=\"ilf-listing\">
  <div class=\"container\">
    ";
        // line 13
        if ((($tmp = ($context["exposed"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 14
            yield "      <div class=\"ilf-listing__filters\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["exposed"] ?? null), "html", null, true);
            yield "</div>
    ";
        }
        // line 16
        yield "
    ";
        // line 17
        if ((array_key_exists("extra_top", $context) && ($context["extra_top"] ?? null))) {
            // line 18
            yield "      ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(($context["extra_top"] ?? null));
            yield "
    ";
        }
        // line 20
        yield "
    ";
        // line 21
        if ((($tmp = ($context["rows"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 22
            yield "      <div class=\"ilf-listing__grid\">
        ";
            // line 23
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["rows"] ?? null), "html", null, true);
            yield "
      </div>
    ";
        } elseif ((($tmp =         // line 25
($context["empty"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 26
            yield "      <div class=\"ilf-listing__empty\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["empty"] ?? null), "html", null, true);
            yield "</div>
    ";
        }
        // line 28
        yield "
    ";
        // line 29
        if ((($tmp = ($context["pager"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 30
            yield "      <div class=\"ilf-listing__pager\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["pager"] ?? null), "html", null, true);
            yield "</div>
    ";
        }
        // line 32
        yield "  </div>
</section>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["kicker", "heading", "intro", "exposed", "extra_top", "rows", "empty", "pager"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "@ilovemyfujitsu/views/views-view--ilf-listing.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  119 => 32,  113 => 30,  111 => 29,  108 => 28,  102 => 26,  100 => 25,  95 => 23,  92 => 22,  90 => 21,  87 => 20,  81 => 18,  79 => 17,  76 => 16,  70 => 14,  68 => 13,  59 => 7,  55 => 6,  51 => 5,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "@ilovemyfujitsu/views/views-view--ilf-listing.html.twig", "/private/tmp/ilovemyfujitsu-drupal/web/themes/custom/ilovemyfujitsu/templates/views/views-view--ilf-listing.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 13];
        static $filters = ["escape" => 1, "raw" => 18];
        static $functions = ["attach_library" => 1];

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape', 'raw'],
                ['attach_library'],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
