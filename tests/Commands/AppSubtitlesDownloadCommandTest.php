<?php
namespace Tests\Commands;

use Commands\AppSubtitlesDownloadCommand;
use Knp\Console\Application;
use Mockery;
use Mockery\Mock;
use Services\SubtitleService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppSubtitlesDownloadCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InputInterface|Mock
     */
    private $input;

    /**
     * @var OutputInterface|Mock
     */
    private $output;

    /**
     * @var SubtitleService|Mock
     */
    private $subtitleService;

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function shouldDownloadSubtitlesForVideoFile()
    {
        $videoFixture = __DIR__ . '/../fixtures/breakdance.avi';
        $command = $this->bootstrapCommand();

        $this->subtitleService
            ->shouldReceive('isSupportedLanguage')
            ->with('en')
            ->andReturn(true)
            ->getMock()
            ->shouldReceive('downloadSubtitlesForVideoFile')
            ->withArgs([$videoFixture, 'en'])
            ->getMock();

        $this->input
            ->shouldReceive('getArgument')
            ->with('video file')
            ->andReturn($videoFixture)
            ->getMock();

        $command->run($this->input, $this->output);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Video file "non-existing-file" could not be found
     */
    public function shouldValidateInputVideoFile()
    {
        $videoFixture = 'non-existing-file';
        $command = $this->bootstrapCommand();

        $this->input
            ->shouldReceive('getArgument')
            ->with('video file')
            ->andReturn($videoFixture)
            ->getMock();

        $command->run($this->input, $this->output);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Language "non-existing-language" not supported
     */
    public function shouldValidateInputLanguage()
    {
        $videoFixture = __DIR__ . '/../fixtures/breakdance.avi';
        $language = 'non-existing-language';
        $command = $this->bootstrapCommand();

        $this->subtitleService
            ->shouldReceive('isSupportedLanguage')
            ->andReturn(false)
            ->getMock()
            ->shouldReceive('getSupportedLanguages')
            ->andReturn(['en', 'es', 'fr', 'it', 'nl', 'pl', 'pt', 'ro','sv', 'tr'])
            ->getMock();

        $this->input
            ->shouldReceive('getArgument')
            ->with('video file')
            ->andReturn($videoFixture)
            ->getMock()
            ->shouldReceive('getArgument')
            ->with('language')
            ->andReturn($language)
            ->getMock();

        $command->run($this->input, $this->output);
    }

    /**
     * @test
     */
    public function shouldReportSuccessCount()
    {
        $videoFixture = __DIR__ . '/../fixtures/breakdance.avi';
        $command = $this->bootstrapCommand();

        $this->subtitleService
            ->shouldReceive('isSupportedLanguage')
            ->with('en')
            ->andReturn(true)
            ->getMock()
            ->shouldReceive('downloadSubtitlesForVideoFile')
            ->withArgs([$videoFixture, 'en'])
            ->andReturn(1)
            ->getMock();

        $this->input
            ->shouldReceive('getArgument')
            ->with('language')
            ->andReturn('en')
            ->getMock()
            ->shouldReceive('getArgument')
            ->with('video file')
            ->andReturn($videoFixture)
            ->getMock();

        $this->output
            ->shouldReceive('writeln')
            ->with('Looking for subtitles')
            ->once()
            ->getMock()
            ->shouldReceive('writeln')
            ->with('Successfully downloaded 1 subtitles "' . $videoFixture . '"')
            ->once()
            ->getMock();

        $command->run($this->input, $this->output);
    }

    /**
     * @test
     */
    public function shouldReportIfNoSubtitlesCouldBefound()
    {
        $videoFixture = __DIR__ . '/../fixtures/breakdance.avi';
        $command = $this->bootstrapCommand();

        $this->subtitleService
            ->shouldReceive('isSupportedLanguage')
            ->with('en')
            ->andReturn(true)
            ->getMock()
            ->shouldReceive('downloadSubtitlesForVideoFile')
            ->withArgs([$videoFixture, 'en'])
            ->andReturn(0)
            ->getMock();

        $this->input
            ->shouldReceive('getArgument')
            ->with('language')
            ->andReturn('en')
            ->getMock()
            ->shouldReceive('getArgument')
            ->with('video file')
            ->andReturn($videoFixture)
            ->getMock();

        $this->output
            ->shouldReceive('writeln')
            ->with('Verifying input language')
            ->once()
            ->getMock()
            ->shouldReceive('writeln')
            ->with('Looking for subtitles')
            ->once()
            ->getMock()
            ->shouldReceive('writeln')
            ->with('No subtitles found for "' . $videoFixture . '" in language "en"')
            ->once()
            ->getMock();

        $command->run($this->input, $this->output);
    }

    /**
     * @return AppSubtitlesDownloadCommand
     */
    private function bootstrapCommand()
    {
        $this->subtitleService = Mockery::mock(SubtitleService::class)
            ->shouldIgnoreMissing();

        $silexApp = Mockery::mock(\Silex\Application::class)
            ->shouldIgnoreMissing()
            ->shouldReceive('offsetGet')
            ->andReturn($this->subtitleService)
            ->getMock();

        $app = new Application($silexApp, __DIR__);

        $command = new AppSubtitlesDownloadCommand();
        $command->setApplication($app);

        $this->input = Mockery::mock(InputInterface::class)
            ->shouldIgnoreMissing();

        $this->output = Mockery::mock(OutputInterface::class)
            ->shouldIgnoreMissing();

        return $command;
    }
}
