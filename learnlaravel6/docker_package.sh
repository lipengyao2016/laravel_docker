#!/bin/sh
docker stop laraveltest && docker rm laraveltest
docker build -t sj/learnlaravel:v2.5 .