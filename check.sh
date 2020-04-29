#!/bin/bash
docker run -ti --rm -v $(pwd):/mnt:ro dkhamsing/awesome_bot \
--allow-redirect \
--allow-dupe \
--skip-save-results \
--allow-ssl \
--white-list https://opensource.magento.com/contribution-day-handbook \
./README.md
