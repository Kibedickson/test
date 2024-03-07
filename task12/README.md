# Asynchronous Processing with Redis Message Queue and PHP

## Introduction

This repository contains a simple example of asynchronous processing using Redis as a message queue and PHP for task handling.

## Setup

1. Install Redis on your server.
3. Run `composer install` to install the required dependencies.

## Usage

1. Open a terminal and run the worker script. This command will start the worker in the background and redirect its output to a log file (worker.log).

    ```bash
    php worker.php > worker.log 2>&1 &
    ```

2. Open another terminal and run the index script:

    ```bash
    php index.php
    ```

3. Check the worker.log for task processing output.
