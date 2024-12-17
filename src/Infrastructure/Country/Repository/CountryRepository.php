<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Country\Repository;

use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class CountryRepository implements CountryRepositoryInterface
{
    public function __construct(
        private HttpClientInterface $countryApi,
        private TokenExtractorInterface $tokenExtractor,
        private RequestStack $requestStack,
    ) {
    }

    #[\Override]
    public function ofName(string $name): array
    {
        if ($this->requestStack->getCurrentRequest() === null) {
            throw new \LogicException('Request not found');
        }

        $response = json_decode($this->countryApi->request('GET', sprintf('%s?name=%s', CountryRepositoryInterface::COUNTRY_URI, $name), [
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->getAuthorizeToken()),
                'RequestHeaderIdentityProvider' => $this->getAuthorityProvider(),
            ],
        ])->getContent(), true);

        return $response['hydra:member'];
    }

    private function getAuthorizeToken(): string
    {
        if ($this->requestStack->getCurrentRequest() === null) {
            throw new \LogicException('Request not found');
        }

        $token = $this->tokenExtractor->extract(
            $this->requestStack->getCurrentRequest(),
        );

        if ($token === false) {
            throw new \LogicException('Token not found');
        }

        return $token;
    }

    private function getAuthorityProvider(): string
    {
        if ($this->requestStack->getCurrentRequest() === null) {
            throw new \LogicException('Request not found');
        }

        if ($this->requestStack->getCurrentRequest()->headers->has(CountryRepositoryInterface::HEADER_IDENTITY_PROVIDER) === false) {
            throw new \LogicException('Identity provider not found');
        }

        $authorityProvider = $this->requestStack->getCurrentRequest()->headers->get(CountryRepositoryInterface::HEADER_IDENTITY_PROVIDER);

        if ($authorityProvider === null) {
            throw new \LogicException('Identity provider is null');
        }

        return $authorityProvider;
    }
}
