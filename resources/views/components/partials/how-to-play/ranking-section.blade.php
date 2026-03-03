<section id="ranking" class="rounded-2xl border border-(--color-card-border) bg-(--color-card) p-6 md:p-8">

    <!-- Header -->
    <div>
        <h2 class="text-xl md:text-2xl font-extrabold text-(--color-primary)">
            🏆 Ranking
        </h2>

        <p class="mt-2 text-sm text-(--color-muted) max-w-2xl">
            O ranking é atualizado automaticamente com base nos palpites validados.
            Abaixo explicamos como os pontos são calculados e quando a classificação é atualizada.
        </p>
    </div>

    <!-- Parte 1 -->
    <div class="mt-8 rounded-2xl border border-(--color-card-border) bg-(--color-background) p-5">

        <div class="flex items-center gap-3">
            <div
                class="h-8 w-8 rounded-full bg-(--color-btn) text-(--color-btn-fg)
                            grid place-items-center text-sm font-bold">
                1
            </div>

            <h3 class="text-sm md:text-base font-semibold text-(--color-primary)">
                Como os pontos são calculados
            </h3>
        </div>

        <p class="mt-3 text-sm text-(--color-muted)">
            Cada palpite validado gera uma pontuação baseada na precisão do resultado:
        </p>

        @php
            $ptsPossibilities = [
                ['label' => '7 pontos', 'description' => 'Placar exato'],
                ['label' => '5 pontos', 'description' => 'Time vencedor + gols de algum dos times'],
                ['label' => '3 pontos', 'description' => 'Time vencedor ou empate'],
                ['label' => '2 pontos', 'description' => 'gols de um dos times'],
                ['label' => '0 pontos', 'description' => 'Nao acertou nada'],
            ];
        @endphp
        <div class="mt-4 grid md:grid-cols-3 gap-3">
            @foreach ($ptsPossibilities as $opts)
                <div class="rounded-xl border border-(--color-card-border) p-4">
                    <p class="text-sm font-semibold text-(--color-primary)">{{ $opts['label'] }}</p>
                    <p class="mt-1 text-xs text-(--color-muted)">
                        {{ $opts['description'] }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="mt-5 rounded-xl border border-(--color-card-border) bg-transparent p-4">
            <p class="text-xs font-semibold text-(--color-muted) uppercase tracking-wide">
                Exemplo prático
            </p>

            <div class="mt-2 text-sm text-(--color-muted) space-y-1">
                <p><span class="font-semibold text-(--color-primary)">Palpite:</span> 2 x 1</p>
                <p><span class="font-semibold text-(--color-primary)">Resultado Final:</span> 2 x 1 → 7 pontos
                </p>
                <p><span class="font-semibold text-(--color-primary)">Resultado Final:</span> 2 x 0 → 5 pontos
                </p>
                <p><span class="font-semibold text-(--color-primary)">Resultado Final:</span> 3 x 2 → 3 pontos
                </p>
                <p><span class="font-semibold text-(--color-primary)">Resultado Final:</span> 0 x 1 → 2 pontos
                </p>
                <p><span class="font-semibold text-(--color-primary)">Resultado Final:</span> 0 x 1 → 0 ponto
                </p>
            </div>
        </div>

    </div>

    <!-- Parte 2 -->
    <div class="mt-6 rounded-2xl border border-(--color-card-border) bg-(--color-background) p-5">

        <div class="flex items-center gap-3">
            <div
                class="h-8 w-8 rounded-full bg-(--color-btn) text-(--color-btn-fg)
                            grid place-items-center text-sm font-bold">
                2
            </div>

            <h3 class="text-sm md:text-base font-semibold text-(--color-primary)">
                Quando os cálculos são realizados
            </h3>
        </div>

        <p class="mt-3 text-sm text-(--color-muted)">
            A pontuação é calculada automaticamente após a validação oficial do resultado da partida.
            Assim que o resultado é confirmado no sistema, os pontos são atribuídos e o ranking é atualizado.
        </p>

        <div class="mt-4 rounded-xl border border-(--color-card-border) p-4">
            <p class="text-sm font-semibold text-(--color-primary)">
                Atualização automática
            </p>

            <p class="mt-2 text-sm text-(--color-muted)">
                O ranking pode ser atualizado imediatamente após a validação do jogo.
                Caso haja algum atraso na validação, a pontuação será ajustada automaticamente assim que o
                resultado
                for confirmado.
            </p>
        </div>

    </div>

</section>
