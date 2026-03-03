 <section id="account" class="rounded-2xl border border-(--color-card-border) bg-(--color-card) p-6 md:p-8">
     <!-- Header -->
     <div>
         <h2 class="text-xl md:text-2xl font-extrabold text-(--color-primary)">
             👤 Conta
         </h2>

         <p class="mt-2 text-sm text-(--color-muted) max-w-2xl">
             Você pode atualizar o email e a senha da sua conta seguindo os passos abaixo.
             As alterações são aplicadas imediatamente após salvar.
         </p>
     </div>

     <!-- Step 1 -->
     <div class="mt-8 rounded-2xl border border-(--color-card-border) bg-(--color-background) p-5">

         <div class="flex items-center gap-3">
             <div
                 class="h-8 w-8 rounded-full bg-(--color-btn) text-(--color-btn-fg)
                            grid place-items-center text-sm font-bold">
                 1
             </div>

             <h3 class="text-sm md:text-base font-semibold text-(--color-primary)">
                 Acesse a página de configurações
             </h3>
         </div>

         <p class="mt-3 text-sm text-(--color-muted)">
             Clique no menu da conta (canto superior direito) e selecione a opção
             <a href="{{ route('account') }}" class="font-semibold text-(--color-primary)">Conta</a>.
         </p>

         <!-- Screenshots -->
         <div class="mt-5 grid md:grid-cols-2 gap-4">

             <!-- Mobile -->
             <div class="rounded-xl border border-(--color-card-border) p-4">
                 <p class="text-xs font-semibold text-(--color-muted) uppercase tracking-wide">
                     Mobile
                 </p>

                 <div
                     class="mt-3 h-56 rounded-xl border border-(--color-card-border)
                                grid place-items-center text-xs text-(--color-muted)">
                     Screenshot mobile - onde clicar para acessar configurações
                 </div>
             </div>

             <!-- Desktop -->
             <div class="rounded-xl border border-(--color-card-border) p-4">
                 <p class="text-xs font-semibold text-(--color-muted) uppercase tracking-wide">
                     Desktop
                 </p>

                 <div
                     class="mt-3 h-56 rounded-xl border border-(--color-card-border)
                                grid place-items-center text-xs text-(--color-muted)">
                     Screenshot desktop - onde clicar para acessar configurações
                 </div>
             </div>

         </div>

     </div>

     <!-- Step 2 -->
     <div class="mt-6 rounded-2xl border border-(--color-card-border) bg-(--color-background) p-5">

         <div class="flex items-center gap-3">
             <div
                 class="h-8 w-8 rounded-full bg-(--color-btn) text-(--color-btn-fg)
                            grid place-items-center text-sm font-bold">
                 2
             </div>

             <h3 class="text-sm md:text-base font-semibold text-(--color-primary)">
                 Atualize seu Email ou Senha
             </h3>
         </div>

         <p class="mt-3 text-sm text-(--color-muted)">
             Na seção de configurações, você encontrará os campos para alterar
             seu email e senha. Após preencher os novos dados, clique em
             <span class="font-semibold text-(--color-primary)">Salvar</span>.
         </p>

         <!-- Screenshots -->
         <div class="mt-5 grid md:grid-cols-2 gap-4">

             <!-- Mobile -->
             <div class="rounded-xl border border-(--color-card-border) p-4">
                 <p class="text-xs font-semibold text-(--color-muted) uppercase tracking-wide">
                     Mobile
                 </p>

                 <div
                     class="mt-3 h-56 rounded-xl border border-(--color-card-border)
                                grid place-items-center text-xs text-(--color-muted)">
                     Screenshot mobile - campos de alteração
                 </div>
             </div>

             <!-- Desktop -->
             <div class="rounded-xl border border-(--color-card-border) p-4">
                 <p class="text-xs font-semibold text-(--color-muted) uppercase tracking-wide">
                     Desktop
                 </p>

                 <div
                     class="mt-3 h-56 rounded-xl border border-(--color-card-border)
                                grid place-items-center text-xs text-(--color-muted)">
                     Screenshot desktop - campos de alteração
                 </div>
             </div>

         </div>

     </div>

 </section>
