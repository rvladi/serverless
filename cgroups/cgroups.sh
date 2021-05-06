#!/usr/bin/env bash

sudo cp -p cgconfig.conf /etc/cgconfig.conf
sudo cp -p cgrules.conf /etc/cgrules.conf

sudo cgconfigparser -l /etc/cgconfig.conf
sudo cgrulesengd
