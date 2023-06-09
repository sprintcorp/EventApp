<?php

// src/Validation/EventFilterValidation.php

namespace App\Validation;

use Symfony\Component\HttpFoundation\Request;

class EventFilterValidation
{
    public function validate(Request $request): void
    {
        $term = $request->query->get('term');
        $date = $request->query->get('date');

        
        if ($term && empty($term)) {
            throw new \InvalidArgumentException('Term is required.');
        }

        
        if ($date && empty($date)) {
            throw new \InvalidArgumentException('Date is required.');
        }

        if($date){

            $dateTime = \DateTimeImmutable::createFromFormat('Y-m-d', $date);
            if (!$dateTime) {
                throw new \InvalidArgumentException('Invalid date format.');
            }

            $currentDate = new \DateTimeImmutable();
            if ($dateTime < $currentDate) {
                throw new \InvalidArgumentException('Date cannot be a past date.');
            }
        }
    }
}
