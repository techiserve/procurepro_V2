<?php

namespace Tests\Feature;

use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use Tests\TestCase;

class ReportsSidebarTest extends TestCase
{
    public function test_reports_menu_groups_all_links_and_opens_the_current_group(): void
    {
        $xpath = $this->menuXPath('/reports/fnb');
        $groups = $xpath->query('//li[contains(@class, "reports-menu__group")]/details');

        $this->assertCount(4, $groups);
        $this->assertSame(
            ['Bank Reports', 'Custom Reports', 'Summary Reports', 'ProcurePro Reports'],
            array_map(fn ($group) => trim($xpath->query('./summary', $group)->item(0)->textContent), iterator_to_array($groups))
        );
        $this->assertCount(13, $xpath->query('//ul[contains(@class, "reports-menu__links")]/li/a'));
        $this->assertTrue($groups->item(0)->hasAttribute('open'));
        $this->assertFalse($groups->item(1)->hasAttribute('open'));
        $this->assertCount(1, $xpath->query('//a[@href="/reports/fnb" and @aria-current="page"]'));
    }

    public function test_reports_menu_is_collapsed_off_report_pages(): void
    {
        $xpath = $this->menuXPath('/home');

        $this->assertCount(0, $xpath->query('//details[@open]'));
        $this->assertCount(0, $xpath->query('//ul[contains(@class, "reports-menu") and @style]'));
    }

    public function test_each_report_route_opens_its_group(): void
    {
        foreach ([
            '/reports/fnb' => 'Bank Reports',
            '/reports' => 'Custom Reports',
            '/itemizedreports' => 'Custom Reports',
            '/dashboard/procurement' => 'Custom Reports',
            '/reports/requisitionreport' => 'Summary Reports',
            '/reports/procureprorequisition' => 'ProcurePro Reports',
        ] as $path => $expectedGroup) {
            $xpath = $this->menuXPath($path);
            $openGroups = $xpath->query('//details[@open]/summary');

            $this->assertCount(1, $openGroups, $path);
            $this->assertSame($expectedGroup, trim($openGroups->item(0)->textContent), $path);
            $this->assertCount(1, $xpath->query('//ul[contains(@class, "reports-menu") and @style]'), $path);
        }
    }

    private function menuXPath(string $path): DOMXPath
    {
        app()->instance('request', Request::create($path, 'GET'));

        $document = new DOMDocument();
        $previous = libxml_use_internal_errors(true);
        try {
            $document->loadHTML(view('html.partials.reports-menu')->render());
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }

        return new DOMXPath($document);
    }
}
