<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_id')->unique();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('gender')->default('পুরুষ');
            $table->string('education')->nullable();
            $table->string('designation')->default('সাধারণ সদস্য');
            $table->string('member_type')->default('সাধারণ সদস্য');
            $table->text('address')->nullable();
            $table->string('phone');
            $table->string('nid')->nullable();
            $table->string('profession')->nullable();
            $table->string('blood_group')->nullable();
            $table->decimal('monthly_fee', 10, 2)->default(100.00);
            $table->string('photo')->nullable();
            $table->string('status')->default('পেন্ডিং');
            $table->date('join_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('email')->nullable();
            $table->string('fb_link')->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });

        Schema::create('committees', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('nid')->nullable();
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('gender')->default('পুরুষ');
            $table->string('blood_group')->nullable();
            $table->string('designation');
            $table->string('profession')->nullable();
            $table->string('education')->nullable();
            $table->string('org')->default('আউলিয়াপুর অগ্রযাত্রা পরিষদ');
            $table->string('fb_link')->nullable();
            $table->text('message')->nullable();
            $table->string('photo')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('member_id')->nullable();
            $table->string('name')->nullable();
            $table->string('fiscal_year')->nullable();
            $table->string('month')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('phone')->nullable();
            $table->string('method');
            $table->string('txn_id')->nullable();
            $table->string('status')->default('পেন্ডিং');
            $table->timestamps();
        });

        Schema::create('blood_donors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('gender')->default('পুরুষ');
            $table->date('dob')->nullable();
            $table->string('blood_group');
            $table->date('last_donation_date')->nullable();
            $table->string('weight')->nullable();
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->string('upazila')->nullable();
            $table->string('village')->nullable();
            $table->string('photo')->nullable();
            $table->string('status')->default('সক্রিয়');
            $table->string('donor_type')->default('সাধারণ');
            $table->string('member_id')->nullable();
            $table->timestamps();
        });

        Schema::create('blood_donations', function (Blueprint $table) {
            $table->id();
            $table->string('donor_type')->default('সাধারণ');
            $table->string('donor_id')->nullable();
            $table->string('donor_name');
            $table->string('donor_father')->nullable();
            $table->string('donor_blood');
            $table->string('donor_phone');
            $table->date('donation_date');
            $table->string('donor_photo')->nullable();
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->string('recipient_address');
            $table->string('recipient_disease');
            $table->string('recipient_photo')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->default('পেন্ডিং');
            $table->timestamps();
        });

        Schema::create('cashbooks', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('type', ['আয়', 'ব্যয়']);
            $table->string('sector');
            $table->decimal('amount', 12, 2);
            $table->text('remarks')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('spent_by')->nullable();
            $table->timestamps();
        });

        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('title');
            $table->string('sector');
            $table->string('amount')->default('০');
            $table->text('desc')->nullable();
            $table->string('status')->default('চলমান');
            $table->string('location')->default('আউলিয়াপুর');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('cashbooks');
        Schema::dropIfExists('blood_donations');
        Schema::dropIfExists('blood_donors');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('committees');
        Schema::dropIfExists('members');
    }
};
