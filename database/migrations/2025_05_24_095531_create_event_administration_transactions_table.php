    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up(): void
        {
            Schema::create('event_administration_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('administration_id')->constrained('event_administrations')->cascadeOnDelete();
                $table->foreignId('payment_id')->constrained('payment_method_clubs')->cascadeOnDelete();
                $table->string('payment_proof');
                $table->integer('amount');
                $table->date('pay_time');
                $table->string('group_token')->nullable();
                $table->boolean('status')->default(1);
                $table->string('desc');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('event_administration_transactions');
        }
    };
