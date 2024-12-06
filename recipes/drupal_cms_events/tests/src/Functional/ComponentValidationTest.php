<?php

declare(strict_types=1);

namespace Drupal\Tests\drupal_cms_events\Functional;

use Drupal\FunctionalTests\Core\Recipe\RecipeTestTrait;
use Drupal\Tests\BrowserTestBase;

/**
 * @group drupal_cms_events
 */
class ComponentValidationTest extends BrowserTestBase {

  use RecipeTestTrait;

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $dir = realpath(__DIR__ . '/../../..');
    // The recipe should apply cleanly.
    $this->applyRecipe($dir);
    // Apply it again to prove that it is idempotent.
    $this->applyRecipe($dir);
  }

  public function testPathAliasPatternPrecedence(): void {
    $dir = realpath(__DIR__ . '/../../../../drupal_cms_seo_basic');
    $this->applyRecipe($dir);

    // Ensure there's at least one text format we can use as an anonymous user.
    $this->applyRecipe('core/recipes/restricted_html_format');

    // Confirm that events have the expected path aliases.
    $node = $this->drupalCreateNode([
      'type' => 'event',
      'title' => 'Grand Jubilee',
    ]);
    $this->assertStringEndsWith('/events/grand-jubilee', $node->toUrl()->toString());
  }


}
