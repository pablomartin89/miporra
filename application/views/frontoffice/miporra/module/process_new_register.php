<div id="processTabs">
						<ul class="process-steps bottommargin clearfix">
							<li>
								<a href="#ptab1" class="i-circled i-bordered i-alt divcenter">1</a>
								<h5>Bienvenido !</h5>
							</li>
							<li>
								<a href="#ptab2" class="i-circled i-bordered i-alt divcenter">2</a>
								<h5>Crea o entra en un grupo</h5>
							</li>
							<li>
								<a href="#ptab3" class="i-circled i-bordered i-alt divcenter">3</a>
								<h5>Invita a tus amigos</h5>
							</li>
							<li>
								<a href="#ptab4" class="i-circled i-bordered i-alt divcenter">4</a>
								<h5>Mete tus resultados</h5>
							</li>
						</ul>
						<div>
							<div id="ptab1">

								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, ipsa, fuga, modi, corporis maiores illum fugit ratione cumque dolores sint obcaecati quod temporibus. Expedita, sapiente, veritatis, impedit iusto labore sed itaque sunt fugiat non quis nihil hic quos necessitatibus officiis mollitia nesciunt neque! Minus, mollitia at iusto unde voluptate repudiandae.</p>


								<a href="#" class="button button-3d nomargin fright tab-linker" rel="2">Entra en un grupo</a>

							</div>
							<div id="ptab2">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nesciunt, deleniti, atque soluta ratione blanditiis maxime at architecto laudantium eius eaque distinctio dolorem voluptatem nam ab molestias velit nemo. Illo, hic.</p>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores, modi, odit, aspernatur veritatis ipsum molestiae impedit iusto blanditiis voluptatem ab voluptas ullam expedita repellendus porro assumenda non deserunt repellat eius rem dolorem corporis temporibus voluptatibus ut! Quod, corporis, tempora, dolore, sint earum minus deserunt eveniet natus error magnam aliquam nemo.</p>
								<div class="line"></div>
								<a href="#" class="button button-3d nomargin tab-linker" rel="1">Atras</a>
								<a href="#" class="button button-3d nomargin fright tab-linker" rel="3">Invita a tus amigos</a>
							</div>
							<div id="ptab3">
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis, sit, culpa, placeat, tempora quibusdam molestiae cupiditate atque tempore nemo tenetur facere voluptates autem aliquid provident distinctio beatae odio maxime pariatur eos ratione quae itaque quod. Distinctio, temporibus, cupiditate, eaque vero illo molestiae vel doloremque dolorum repellat ullam possimus modi dicta eum debitis ratione est in sunt et corrupti adipisci quibusdam praesentium optio laborum tempora ipsam aut cum consectetur veritatis dolorem.</p>
								<div class="line"></div>
								<a href="#" class="button button-3d nomargin tab-linker" rel="2">Previous</a>
								<a href="#" class="button button-3d nomargin fright tab-linker" rel="4">Finalizar</a>
							</div>
							<div id="ptab4">
								<div class="alert alert-success">
									<strong>Thank You.</strong> Your order will be processed once we verify the Payment.
								</div>
							</div>
						</div>
					</div>

					<script>
					  $(function() {
						$( "#processTabs" ).tabs({ show: { effect: "fade", duration: 400 } });
						$( ".tab-linker" ).click(function() {
							$( "#processTabs" ).tabs("option", "active", $(this).attr('rel') - 1);
							return false;
						});
					  });
					</script>

					<div class="clear"></div>
