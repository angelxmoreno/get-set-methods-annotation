#!/usr/bin/env bash

osx_reporter_url="https://codeclimate.com/downloads/test-reporter/test-reporter-latest-darwin-amd64"
linux_reporter_url="https://codeclimate.com/downloads/test-reporter/test-reporter-latest-linux-amd64"
dl_url=false

unameOut="$(uname -s)"
case "${unameOut}" in
    Linux*)     machine=Linux; dl_url=${linux_reporter_url};;
    Darwin*)    machine=Mac; dl_url=${osx_reporter_url};;
    CYGWIN*)    machine=Cygwin;;
    MINGW*)     machine=MinGw;;
    *)          machine="UNKNOWN:${unameOut}"
esac

if [ ${dl_url} == false ];then
    echo "Not compatible with ${machine} platforms"
    exit
else
    echo "Downloading ${machine}-compatible reporter"
fi

curl -L ${dl_url} > ./cc-test-reporter
chmod +x ./cc-test-reporter