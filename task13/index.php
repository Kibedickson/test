<?php

function serializeAndCompress($data): false|string
{
    $serializedData = serialize($data);
    return gzcompress($serializedData);
}

function saveToFile(string $filename, $data): void
{
    file_put_contents($filename, $data);
    echo "Data saved to $filename\n";
}

function readFromFile(string $filename): false|string
{
    return file_get_contents($filename);
}

function decompressAndUnserialize($compressedData)
{
    $uncompressedData = gzuncompress($compressedData);
    return unserialize($uncompressedData);
}

$largeData = array(
    'key1' => 'value1',
    'key2' => 'value2',
    'key3' => 'value3',
    'key4' => 'value4',
    'key5' => 'value5',
    'key6' => 'value6',
    'key7' => 'value7',
    'key8' => 'value8',
    'key9' => 'value9',
    'key10' => 'value10',
);

$compressedData = serializeAndCompress($largeData);
saveToFile('compressed_data.dat', $compressedData);

$readCompressedData = readFromFile('compressed_data.dat');
$unserializedData = decompressAndUnserialize($readCompressedData);

print_r($unserializedData);