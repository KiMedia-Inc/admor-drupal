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

/* themes/custom/ilovemyfujitsu/templates/content/node--news-update.html.twig */
class __TwigTemplate_6f75f2aed7f3b9c292beb9eec321ec3f extends Template
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
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", ["ilf-structured-node", "ilf-structured-node--news"], "method", false, false, true, 1), "html", null, true);
        yield ">
  <header class=\"fujitsu-page-hero\">
    <div class=\"container\">
      <p class=\"fujitsu-eyebrow\">Fujitsu Hawaii Update</p>
      <h1>";
        // line 5
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["label"] ?? null), "html", null, true);
        yield "</h1>
    </div>
  </header>

  <div class=\"fujitsu-page-body\">
    <div class=\"container\">
      <div class=\"ilf-detail-card ilf-news-detail\">
        <div class=\"ilf-detail-card__main\">
          ";
        // line 13
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_featured_image", [], "any", false, false, true, 13), "target_id", [], "any", false, false, true, 13) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_featured_image", [], "any", false, false, true, 13), "entity", [], "any", false, false, true, 13))) {
            // line 14
            yield "            <img
              class=\"ilf-detail-card__hero-image\"
              src=\"";
            // line 16
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->getFileUrl(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_featured_image", [], "any", false, false, true, 16), "entity", [], "any", false, false, true, 16), "uri", [], "any", false, false, true, 16), "value", [], "any", false, false, true, 16)), "html", null, true);
            yield "\"
              alt=\"";
            // line 17
            yield ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_featured_image", [], "any", false, false, true, 17), "alt", [], "any", false, false, true, 17)) ? ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_featured_image", [], "any", false, false, true, 17), "alt", [], "any", false, false, true, 17), "html", null, true)) : ($this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (Twig\Extension\CoreExtension::striptags($this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(($context["label"] ?? null))) . " image"), "html", null, true)));
            yield "\"
            >
          ";
        }
        // line 20
        yield "          ";
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_summary", [], "any", false, false, true, 20), "value", [], "any", false, false, true, 20)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 21
            yield "            <p class=\"ilf-profile-summary\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::striptags(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "field_summary", [], "any", false, false, true, 21), "value", [], "any", false, false, true, 21)), "html", null, true);
            yield "</p>
          ";
        }
        // line 23
        yield "          ";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "body", [], "any", false, false, true, 23), "html", null, true);
        yield "
        </div>
        <aside class=\"ilf-detail-card__aside\" aria-label=\"Next steps\">
          <h2>Next step</h2>
          <p>Use this update as another reason to request Fujitsu when comparing AC brands in Hawaii.</p>
          ";
        // line 28
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_external_link", [], "any", false, false, true, 28), "html", null, true);
        yield "
          <a class=\"btn-main\" href=\"/find-a-fujitsu-contractor\">Find a Fujitsu Dealer</a>
          <a class=\"btn-main btn-outline\" href=\"/resources\">Review resources</a>
        </aside>
      </div>
    </div>
  </div>
</article>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["attributes", "label", "node", "content"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/ilovemyfujitsu/templates/content/node--news-update.html.twig";
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
        return array (  97 => 28,  88 => 23,  82 => 21,  79 => 20,  73 => 17,  69 => 16,  65 => 14,  63 => 13,  52 => 5,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/ilovemyfujitsu/templates/content/node--news-update.html.twig", "/private/tmp/ilovemyfujitsu-drupal/web/themes/custom/ilovemyfujitsu/templates/content/node--news-update.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 13];
        static $filters = ["escape" => 1, "striptags" => 17, "render" => 17];
        static $functions = ["file_url" => 16];

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape', 'striptags', 'render'],
                ['file_url'],
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
