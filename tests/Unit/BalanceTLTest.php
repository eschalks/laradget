<?php

it('properly parses ISO8601 dates', function () {
    \Carbon\Carbon::createFromFormat(DATE_RFC3339_EXTENDED, '2022-12-04T11:37:25.572Z');
});
