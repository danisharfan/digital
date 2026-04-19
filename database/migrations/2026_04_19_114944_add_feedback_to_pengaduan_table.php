use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->text('feedback')->nullable()->after('status');
            $table->timestamp('feedback_at')->nullable()->after('feedback');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            $table->dropColumn(['feedback', 'feedback_at']);
        });
    }
};