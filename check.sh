#!/bin/bash

# Add "--request-delay 1" option in case github.com limits the requests
# See https://github.com/dkhamsing/awesome_bot/blob/master/README.md#command-line

docker run -ti --rm -v $(pwd):/mnt:ro dkhamsing/awesome_bot \
--allow-dupe \
--skip-save-results \
--allow-ssl \
--allow-redirect \
--allow 206 \
--white-list https://opensource.magento.com/contribution-day-handbook,https://marketplace.magento.com,https://account.magento.com/scanner/  \
./README.md
