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

/* themes/custom/ilovemyfujitsu/templates/content/node--resource-brochure--teaser.html.twig */
class __TwigTemplate_25a94416976a51bf06cc5e451cbd17b5 extends Template
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
        yield "<article";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", ["ilf-teaser-card", "ilf-teaser-card--resource"], "method", false, false, true, 1), "html", null, true);
        yield ">
  <div class=\"ilf-teaser-card__body\">
    <p class=\"ilf-teaser-card__type\">";
        // line 3
        yield ((($context["resource_category"] ?? null)) ? ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["resource_category"], "html", null, true)) : ("Fujitsu resource"));
        yield "</p>
    <h2><a href=\"";
        // line 4
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["url"] ?? null), "html", null, true);
        yield "\">";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["label"] ?? null), "html", null, true);
        yield "</a></h2>
    <div class=\"ilf-resource-meta\">
      <span class=\"ilf-resource-icon\" aria-hidden=\"true\">PDF</span>
      ";
        // line 7
        if ((($tmp = ($context["resource_file_size"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 8
            yield "        <span>";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["resource_file_size"] ?? null), "html", null, true);
            yield "</span>
      ";
        } else {
            // line 10
            yield "        <span>Online resource</span>
      ";
        }
        // line 12
        yield "    </div>
    ";
        // line 13
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "body", [], "any", false, false, true, 13), "html", null, true);
        yield "
    ";
        // line 14
        if ((($tmp = ($context["resource_file_url"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 15
            yield "      <a class=\"btn-main ilf-teaser-card__action\" href=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["resource_file_url"] ?? null), "html", null, true);
            yield "\">Download PDF</a>
    ";
        } elseif ((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source,         // line 16
($context["node"] ?? null), "field_resource_link", [], "any", false, false, true, 16), "uri", [], "any", false, false, true, 16)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 17
            yield "      ";
            $context["resource_href"] = (((is_string($_v0 = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_resource_link", [], "any", false, false, true, 17), "uri", [], "any", false, false, true, 17)) && is_string($_v1 = "internal:") && str_starts_with($_v0, $_v1))) ? (Twig\Extension\CoreExtension::replace(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_resource_link", [], "any", false, false, true, 17), "uri", [], "any", false, false, true, 17), ["internal:" => ""])) : (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_resource_link", [], "any", false, false, true, 17), "uri", [], "any", false, false, true, 17)));
            // line 18
            yield "      <a class=\"btn-main ilf-teaser-card__action\" href=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["resource_href"] ?? null), "html", null, true);
            yield "\">";
            yield ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_resource_link", [], "any", false, false, true, 18), "title", [], "any", false, false, true, 18)) ? ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_resource_link", [], "any", false, false, true, 18), "title", [], "any", false, false, true, 18), "html", null, true)) : ("Open resource file"));
            yield "</a>
    ";
        }
        // line 20
        yield "    <a class=\"ilf-teaser-card__link\" href=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["url"] ?? null), "html", null, true);
        yield "\">Open resource</a>
  </div>
</article>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["attributes", "resource_category", "url", "label", "resource_file_size", "content", "resource_file_url", "node"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/ilovemyfujitsu/templates/content/node--resource-brochure--teaser.html.twig";
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
        return array (  101 => 20,  93 => 18,  90 => 17,  88 => 16,  83 => 15,  81 => 14,  77 => 13,  74 => 12,  70 => 10,  64 => 8,  62 => 7,  54 => 4,  50 => 3,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/ilovemyfujitsu/templates/content/node--resource-brochure--teaser.html.twig", "/private/tmp/ilovemyfujitsu-drupal/web/themes/custom/ilovemyfujitsu/templates/content/node--resource-brochure--teaser.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 7, "set" => 17];
        static $filters = ["escape" => 1, "replace" => 17];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'set'],
                ['escape', 'replace'],
                [],
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
