import { usePage, router } from "@inertiajs/react";
import { useState } from "react";
import HistoryCard from "../components/HistoryCard";
import AppLayout from "../layouts/AppLayouts";

function CheckHistory() {
    const { checkups = [], startMonth, endMonth, year } = usePage().props;

    const [filters, setFilters] = useState({
        start_month: startMonth,
        end_month: endMonth,
        year: year,
    });

    const applyFilter = () => {
        router.get(route("check-history"), filters, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    // 🔹 getBadgeColor dipindah ke luar map
    const getBadgeColor = (status) => {
        switch (status) {
            case "Baik":
                return "bg-custom-emerald text-white";
            case "Cukup":
                return "bg-yellow-500 text-white";
            default:
                return "bg-red-500 text-white";
        }
    };

    return (
        <div className="container mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            {/* FILTER */}
            <div className="px-0 sm:px-4 md:px-8 py-2 mt-7">
                <div className="flex flex-wrap justify-center items-center gap-2 md:gap-4">
                    <span className="text-sm font-medium text-gray-700">
                        Urutkan dari:
                    </span>
                    {/* Start Month */}
                    <select
                        className="border rounded px-2 py-1 text-sm"
                        value={filters.start_month}
                        onChange={(e) =>
                            setFilters({
                                ...filters,
                                start_month: e.target.value,
                            })
                        }
                    >
                        {[...Array(12)].map((_, i) => (
                            <option key={i + 1} value={i + 1}>
                                {new Date(0, i).toLocaleString("id-ID", {
                                    month: "long",
                                })}
                            </option>
                        ))}
                    </select>

                    <span className="text-sm">-</span>

                    {/* End Month */}
                    <select
                        className="border rounded px-2 py-1 text-sm"
                        value={filters.end_month}
                        onChange={(e) =>
                            setFilters({
                                ...filters,
                                end_month: e.target.value,
                            })
                        }
                    >
                        {[...Array(12)].map((_, i) => (
                            <option key={i + 1} value={i + 1}>
                                {new Date(0, i).toLocaleString("id-ID", {
                                    month: "long",
                                })}
                            </option>
                        ))}
                    </select>

                    {/* Year */}
                    <select
                        className="border rounded px-2 py-1 text-sm"
                        value={filters.year}
                        onChange={(e) =>
                            setFilters({ ...filters, year: e.target.value })
                        }
                    >
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                    </select>

                    <button
                        onClick={applyFilter}
                        className="bg-custom-emerald text-white px-4 py-1 rounded text-sm font-medium"
                    >
                        Terapkan
                    </button>
                </div>
            </div>

            {/* Garis pemisah */}
            <div className="px-0 sm:px-4 md:px-8">
                <hr className="border-2 border-custom-emerald" />
            </div>

            {/* CARD DATA */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {checkups.length === 0 ? (
                    <p className="text-gray-500 text-center">
                        Tidak ada data pemeriksaan.
                    </p>
                ) : (
                    checkups.map((item, index) => {
                        const baseProps = {
                            type:
                                item.category === "Toddler"
                                    ? "Balita"
                                    : item.category === "Adult"
                                    ? "Dewasa"
                                    : item.category === "Infant"
                                    ? "Bayi"
                                    : item.category, // default
                            nik: item.nik,
                            name: item.name,
                            gender:
                                item.gender && item.gender !== ""
                                    ? item.gender
                                    : "-",
                            birthDate: item.birth_date ?? "-",
                            age: item.age,
                            examDate: item.checkup_date,
                            badgeText: item.status,
                            badgeColor: getBadgeColor(item.status),
                        };

                        if (item.category === "Infant") {
                            return (
                                <HistoryCard
                                    key={index}
                                    {...baseProps}
                                    weight={item.weight ?? "-"}
                                    height={item.height ?? "-"}
                                    headCircumference={
                                        item.head_circumference ?? "-"
                                    }
                                    birthWeight={item.birth_weight ?? "-"}
                                    birthHeight={item.birth_height ?? "-"}
                                    checkupDate={item.checkup_date ?? "-"}
                                    nutritionStatus={
                                        item.nutrition_status ?? "-"
                                    }
                                    completeImmunization={
                                        item.infant_data
                                            ?.complete_immunization ?? "Belum"
                                    }
                                    vitaminA={item.vitamin_a ?? "Tidak"}
                                    stuntingStatus={item.stunting_status ?? "-"}
                                    exclusiveBreastfeeding={
                                        item.infant_data
                                            ?.exclusive_breastfeeding ?? "Tidak"
                                    }
                                    complementaryFeeding={
                                        item.infant_data
                                            ?.complementary_feeding ?? "Tidak"
                                    }
                                    motorDevelopment={
                                        item.motor_development ?? "-"
                                    }
                                />
                            );
                        }

                        if (item.category === "Adult") {
                            return (
                                <HistoryCard
                                    key={index}
                                    {...baseProps}
                                    weight={item.weight ?? "-"}
                                    height={item.height ?? "-"}
                                    bloodPressure={item.blood_pressure ?? "-"}
                                    bloodGlucose={item.blood_glucose ?? "-"}
                                    cholesterol={item.cholesterol ?? "-"}
                                    bmi={item.bmi ?? "-"}
                                />
                            );
                        }

                        if (item.category === "Toddler") {
                            return (
                                <HistoryCard
                                    key={index}
                                    {...baseProps}
                                    category={item.category}
                                    weight={item.weight ?? "-"}
                                    height={item.height ?? "-"}
                                    upperArmCircumference={
                                        item.upper_arm_circumference ?? "-"
                                    }
                                    nutritionStatus={
                                        item.nutrition_status ?? "-"
                                    }
                                    vitaminA={item.vitamin_a ?? "Tidak"}
                                    immunizationFollowup={
                                        item.immunization_followup ?? "Tidak"
                                    }
                                    foodSupplement={
                                        item.food_supplement ?? "Tidak"
                                    }
                                    parentingEducation={
                                        item.parenting_education ?? "Tidak"
                                    }
                                    stuntingStatus={item.stunting_status ?? "-"}
                                    motorDevelopment={
                                        item.motor_development ?? "-"
                                    }
                                    checkupDate={item.checkup_date ?? "-"}
                                />
                            );
                        }

                        if (item.category === "Elderly") {
                            return (
                                <HistoryCard
                                    key={index}
                                    {...baseProps}
                                    category={item.category}
                                    weight={item.weight ?? "-"}
                                    height={item.height ?? "-"}
                                    bloodPressure={item.blood_pressure ?? "-"}
                                    bloodGlucose={item.blood_glucose ?? "-"}
                                    cholesterol={item.cholesterol ?? "-"}
                                    nutritionStatus={
                                        item.nutrition_status ?? "-"
                                    }
                                    functionalAbility={
                                        item.functional_ability ?? "-"
                                    }
                                    chronicDiseaseHistory={
                                        item.chronic_disease_history ?? "-"
                                    }
                                    checkupDate={item.checkup_date ?? "-"}
                                />
                            );
                        }

                        // default kategori lain
                        return (
                            <HistoryCard
                                key={index}
                                {...baseProps}
                                weight={item.weight ?? "-"}
                                height={item.height ?? "-"}
                                nutritionStatus={item.nutrition_status ?? "-"}
                                stuntingStatus={item.stunting_status ?? "-"}
                            />
                        );
                    })
                )}
            </div>
        </div>
    );
}

CheckHistory.layout = (page) => <AppLayout>{page}</AppLayout>;
export default CheckHistory;
