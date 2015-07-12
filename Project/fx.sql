CREATE FUNCTION fGetInstallCost
(
	@tag_no	INT,
	@rev_no	INT
)
RETURNS DECIMAL(8,2)

AS
BEGIN
	DECLARE @mat_cost		DECIMAL(8,2);
	DECLARE @labor_cost		DECIMAL(8,2);
	DECLARE @eng_cost		DECIMAL(8,2);
	DECLARE @install_cost	DECIMAL(8,2);
	
	SELECT @mat_cost = Material_Cost, @labor_cost = Labor_Cost*Labor_Hours, 
			@eng_cost = Engineering_Cost*Engineering_Hours
	FROM TAG
	WHERE @tag_no = Tag_No AND @rev_no = Rev_No;
	
	SET @install_cost = @mat_cost + @labor_cost + @eng_cost;
	RETURN @install_cost;
END

GO
