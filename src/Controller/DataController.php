<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    #[Route('/', name: 'SHOW_VALUE')]
    public function showValue(): Response
    {
        $value = $this->getStartOfPacketMarker();

        return $this->render('data.html.twig', [
            'value' => $value,
        ]);
    }

    public function getDataFromFile(): bool|string
    {
        return file_get_contents('/home/noa/PhpstormProjects/AdventsOfCode/Day6/src/data.txt');
    }

    public function getStartOfPacketMarker(): int
    {
        $file = $this->getDataFromFile();
        $splitArray = $this->split_array($file);
        $array = $this->getSplitArray($splitArray);

        return $this->checkChars($array);
    }

    public function split_array(string $file): array
    {
        return str_split($file);
    }

    public function getSplitArray(array $data): array
    {
        $combinedArray = [];
        $array = [];
        $sum = 0;
        foreach ($data as $key => $value) {
            $combinedArray[$key] = $value;
            if (count($combinedArray) == 4) {
                $array[$sum] = $combinedArray;
                array_shift($combinedArray);
                $sum+=1;
            }
        }
        return $array;
    }

    public function checkChars(array $data): int|null
    {
        $sum = 0;
        foreach ($data as $item) {
            if (count(array_unique($item)) != 4) {
                $sum += 1;
            } else {
                $sum += 4;
                return $sum;
            }
        }

        return null;
    }
}