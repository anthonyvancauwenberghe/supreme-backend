<?php

namespace Modules\Creditcard\Permissions;

interface CreditcardPermission
{
    const INDEX_CREDITCARD = 'creditcard.index';
    const SHOW_CREDITCARD = 'creditcard.show';
    const UPDATE_CREDITCARD = 'creditcard.update';
    const CREATE_CREDITCARD = 'creditcard.create';
    const DELETE_CREDITCARD = 'creditcard.delete';
}
