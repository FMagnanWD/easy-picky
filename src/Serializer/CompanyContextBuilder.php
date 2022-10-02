<?php

namespace App\Serializer;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use ApiPlatform\Serializer\SerializerContextBuilderInterface;

final class CompanyContextBuilder implements SerializerContextBuilderInterface
{
    private $decorated;
    private $authorizationChecker;

    public function __construct(SerializerContextBuilderInterface $decorated, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function createFromRequest(Request $request, bool $normalization, ?array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        $resourceClass = $context['resource_class'] ?? null;

        if ( 
            isset($context['groups']) && 
            $this->authorizationChecker->isGranted('ROLE_CLIENT')
        ) {
            if ($normalization) {
                 if($this->authorizationChecker->isGranted('ROLE_CLIENT_EXTENDED')){
                    $context['groups'][] = 'read:client:extended';    
                 } else {
                    $context['groups'][] = 'read:client:restricted';
                 }
            } else {
                if ($this->authorizationChecker->isGranted('ROLE_CLIENT_EXTENDED')) {
                    $context['groups'][] = 'write:client:extended';
                } else {

                    $context['groups'][] = 'write:client:restricted';
                }
            }
        }

        return $context;
    }
}