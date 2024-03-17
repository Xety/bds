<?php

namespace BDS\Livewire\Traits;

use BDS\Models\Material;
use BDS\Models\Part;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use ReflectionException;

trait WithQrCode
{
    /**
     * The image generated by the Qr Code builder.
     *
     * @var string
     */
    public string $qrCodeImg = '';

    /**
     * The size of the QR Code image.
     *
     * @var int
     */
    public int $qrCodeSize = 200;

    /**
     * The label used below the QR Code image.
     *
     * @var string
     */
    public string $qrCodeLabel = '';

    /**
     * The model used to generate the QR Code.
     *
     * @var Material|Part|null
     */
    public Material|Part|null $modelQrCode = null;

    /**
     * Used to show the QR Code modal.
     *
     * @var bool
     */
    public bool $showQrCodeModal = false;

    /**
     * The size allowed ofr a QR Code image.
     *
     * @var array
     */
    public array $allowedQrCodeSize = [
        100 => [
            'pixels' => 100,
            'image_size' => 30,
            'text' => 'Très Petit',
            'font_size' => 8
        ],
        150 => [
            'pixels' => 150,
            'image_size' => 40,
            'text' => 'Petit',
            'font_size' => 9
        ],
        200 => [
            'pixels' => 200,
            'image_size' => 50,
            'text' => 'Normal',
            'font_size' => 10
        ],
        300 => [
            'pixels' => 300,
            'image_size' => 50,
            'text' => 'Moyen',
            'font_size' => 12
        ],
        400 => [
            'pixels' => 400,
            'image_size' => 70,
            'text' => 'Grand',
            'font_size' => 14
        ],
        500 => [
            'pixels' => 500,
            'image_size' => 90,
            'text' => 'Très Grand',
            'font_size' => 17
        ]
    ];

    /**
     * Get the model by the model type, assign the name to the label, build the QR Code and show the modal.
     *
     * @param Material|Part $model The model used for showing the QrCode.
     *
     * @return void
     *
     * @throws ReflectionException
     */
    public function showQrCode(Material|Part $model): void
    {
        $this->authorize('generateQrCode', $model);

        $this->modelQrCode = $model;
        $this->qrCodeLabel = $model->name;

        $result = $this->buildImage();
        $this->qrCodeImg = $result;

        $this->showQrCodeModal = true;
    }

    /**
     * Build the QR Code image.
     *
     * @return string
     *
     * @throws ReflectionException
     */
    public function buildImage(): string
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data(route('dashboard.index', ['qrcode' => 'true', 'type' => strtolower((new \ReflectionClass($this->model))->getShortName()), 'qrcodeId' => $this->modelQrCode->getKey()]))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size($this->qrCodeSize)
            ->margin(0)
            ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->logoPath(public_path('images/logos/selvah_600x600_fond_blanc_qrcode.png'))
            ->logoResizeToWidth($this->allowedQrCodeSize[$this->qrCodeSize]['image_size'])
            ->logoPunchoutBackground(true)
            ->labelText($this->qrCodeLabel)
            ->labelFont(new OpenSans($this->allowedQrCodeSize[$this->qrCodeSize]['font_size']))
            ->labelAlignment(LabelAlignment::Center)
            ->build();

        return $result->getDataUri();
    }

    /**
     * When the label is updated, re-build the image with the new label value.
     *
     * @return void
     *
     * @throws ReflectionException
     */
    public function updatedQrCodeLabel(): void
    {
        $result = $this->buildImage();
        $this->qrCodeImg = $result;
    }

    /**
     * When the size is updated, check the validity of the size then re-build the image with the new size value.
     *
     * @param int $field The new size value.
     *
     * @return void
     *
     * @throws ReflectionException
     */
    public function updatedQrCodeSize(int $field): void
    {
        // Prevent user that update the HTML value to set a not allowed value.
        if (!array_key_exists($field, $this->allowedQrCodeSize)) {
            $this->qrCodeSize = 200;
        }

        $result = $this->buildImage();
        $this->qrCodeImg = $result;
    }
}
