<?php

namespace Oro\Bundle\GoogleDataStudioDashboardBundle\Tests\Functional\Controller;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;

class DashboardControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        $this->initClient([], $this->generateBasicAuthHeader());
        $this->client->useHashNavigation(true);
    }

    public function testIndex()
    {
        $this->client->request('GET', $this->getUrl('oro_dashboard_index'));
        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);
    }

    public function testCreate()
    {
        $crawler = $this->client->request('GET', $this->getUrl('oro_dashboard_create'));
        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);

        $createForm = $crawler->selectButton('Save and Close')->form();
        $createForm['oro_dashboard[label]'] = 'Google Data Studio Dashboard';
        $createForm['oro_dashboard[type]'] = 'google_data_studio';
        $createForm['oro_dashboard[embed_url]'] = 'https://datastudio.google.com/embed/reporting/test';

        $this->client->followRedirects(true);
        $crawler = $this->client->submit($createForm);

        $html = $crawler->html();
        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);

        static::assertStringContainsString('Dashboard saved', $html);
        static::assertStringContainsString('Google Data Studio Dashboard', $html);
    }

    /**
     * @depends testCreate
     */
    public function testUpdate()
    {
        $crawler = $this->client->request(
            'GET',
            $this->getUrl('oro_dashboard_update', ['id' => $this->getEntityIdFromGrid('Google Data Studio Dashboard')])
        );
        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);

        $createForm = $crawler->selectButton('Save and Close')->form();
        $createForm['oro_dashboard[label]'] = 'Google Data Studio Dashboard Update';
        $createForm['oro_dashboard[type]'] = 'google_data_studio';
        $createForm['oro_dashboard[embed_url]'] = 'https://datastudio.google.com/embed/reporting/test';

        $this->client->followRedirects(true);
        $crawler = $this->client->submit($createForm);

        $html = $crawler->html();
        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);

        static::assertStringContainsString('Dashboard saved', $html);
        static::assertStringContainsString('Google Data Studio Dashboard Update', $html);
    }

    /**
     * @depends testUpdate
     */
    public function testView()
    {
        $crawler = $this->client->request(
            'GET',
            $this->getUrl(
                'oro_dashboard_view',
                ['id' => $this->getEntityIdFromGrid('Google Data Studio Dashboard Update')]
            )
        );
        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, 200);

        static::assertStringContainsString('Google Data Studio Dashboard Update', $crawler->html());
    }

    /**
     * @param string $label
     * @return string
     */
    protected function getEntityIdFromGrid($label)
    {
        $response = $this->client->requestGrid(
            'dashboards-grid',
            [
                'dashboards-grid[_filter][label][type]' => $label,
            ]
        );

        $result = $this->getJsonResponseContent($response, 200);

        $result = reset($result['data']);

        return $result['id'];
    }
}
