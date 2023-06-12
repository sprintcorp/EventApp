<?php

namespace App\Validation;

use Symfony\Component\HttpFoundation\Request;

class EventFilterValidation
{
    public function validate(Request $request): void
    {
        $term = $request->query->get('term');
        $date = $request->query->get('date');
        $page = $request->query->get('page');
        $perPage = $request->query->get('perPage');

        
        if ($term && empty($term)) {
            throw new \InvalidArgumentException('Term is required.');
        }

        
        if ($date && empty($date)) {
            throw new \InvalidArgumentException('Date is required.');
        }

        if ($page && !is_numeric($page)) {
            throw new \InvalidArgumentException('Page must be a numeric value');
        }

        if ($perPage && !is_numeric($perPage)) {
            throw new \InvalidArgumentException('Per page must be a numeric value');
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
